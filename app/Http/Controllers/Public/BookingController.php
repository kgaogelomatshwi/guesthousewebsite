<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Services\Payments\PaymentGatewayManager;
use App\Services\SettingsService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function store(Request $request, SettingsService $settings, PaymentGatewayManager $gatewayManager): RedirectResponse
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $room = null;
        $currency = $settings->get('currency', 'ZAR');
        $basePrice = 0;

        if (! empty($data['room_id'])) {
            $room = Room::find($data['room_id']);
            if ($room) {
                $basePrice = (float) $room->base_price;
                $currency = $room->currency ?: $currency;
            }
        }

        $checkIn = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $total = $basePrice * $nights;
        $deposit = $this->calculateDeposit($total, (string) $settings->get('deposit_policy', '0'));

        $booking = Booking::create([
            'code' => strtoupper(substr(sha1(uniqid('', true)), 0, 8)),
            'status' => 'pending',
            'guest_name' => $data['guest_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guests' => $data['guests'],
            'room_id' => $room?->id,
            'total_amount' => $total,
            'deposit_amount' => $deposit,
            'currency' => $currency,
            'notes' => $data['notes'] ?? null,
            'source' => 'direct',
        ]);

        $provider = $settings->get('payment_provider', 'stub');
        Payment::create([
            'booking_id' => $booking->id,
            'provider' => $provider,
            'amount' => $deposit > 0 ? $deposit : $total,
            'currency' => $currency,
            'status' => 'initiated',
        ]);

        $gateway = $gatewayManager->resolve((string) $provider);

        return $gateway->initiatePayment($booking);
    }

    public function otaRedirect(Request $request, SettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'platform' => ['required', 'in:bookingcom,airbnb'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'rooms' => ['nullable', 'integer', 'min:1'],
        ]);

        $platform = $data['platform'];
        $baseUrl = $settings->get($platform === 'bookingcom' ? 'bookingcom_url' : 'airbnb_url');

        if (empty($baseUrl)) {
            return back()->with('error', 'OTA link is not configured yet.');
        }

        $checkIn = Carbon::parse($data['check_in'])->format('Y-m-d');
        $checkOut = Carbon::parse($data['check_out'])->format('Y-m-d');
        $guests = (string) $data['guests'];
        $rooms = (string) ($data['rooms'] ?? 1);

        $url = strtr($baseUrl, [
            '{check_in}' => $checkIn,
            '{check_out}' => $checkOut,
            '{adults}' => $guests,
            '{guests}' => $guests,
            '{rooms}' => $rooms,
        ]);

        if ($url === $baseUrl) {
            $query = http_build_query([
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'guests' => $guests,
                'rooms' => $rooms,
            ]);
            $url = $baseUrl . (str_contains($baseUrl, '?') ? '&' : '?') . $query;
        }

        return redirect()->away($url);
    }

    public function thankYou(): View
    {
        return view('public.pages.booking-thank-you');
    }

    private function calculateDeposit(float $total, string $policy): float
    {
        $policy = trim($policy);
        if ($policy === '') {
            return 0;
        }

        if (str_contains($policy, '%')) {
            $percent = (float) str_replace('%', '', $policy);
            return round(($percent / 100) * $total, 2);
        }

        $fixed = (float) $policy;
        return min($fixed, $total);
    }
}
