<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreEnquiryRequest;
use App\Mail\EnquiryConfirmation;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Models\Page;
use App\Models\Room;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function create(SettingsService $settings): View|RedirectResponse
    {
        if (($settings->get('booking_mode', 'DIRECT_BOOKING')) === 'OTA_REDIRECT') {
            $otaUrl = $this->resolveDefaultOtaUrl($settings);
            if ($otaUrl) {
                return redirect()->away($otaUrl);
            }

            return redirect()->route('home')->with('error', 'OTA link is not configured yet.');
        }

        $page = Page::query()
            ->where('key', 'booking')
            ->where('is_active', true)
            ->with(['sections' => fn ($query) => $query->where('is_active', true)->orderBy('position')])
            ->firstOrFail();

        $rooms = Room::query()->where('status', 'active')->orderBy('title')->get();

        return view('public.pages.show', compact('page', 'rooms'));
    }

    public function store(StoreEnquiryRequest $request, SettingsService $settings): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['guests'])) {
            $adults = (int) ($data['adults'] ?? 0);
            $children = (int) ($data['children'] ?? 0);
            $data['guests'] = max(1, $adults + $children);
        }

        $enquiry = Enquiry::create($data);

        $adminEmail = $settings->get('email');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new EnquiryReceived($enquiry));
        }

        Mail::to($enquiry->email)->send(new EnquiryConfirmation($enquiry));

        $whatsapp = $settings->get('whatsapp');
        $whatsAppLink = null;
        if ($whatsapp) {
            $text = urlencode("Hi, I just sent an enquiry for {$enquiry->check_in} to {$enquiry->check_out}. My name is {$enquiry->name}.");
            $whatsAppLink = "https://wa.me/{$whatsapp}?text={$text}";
        }

        return redirect()->route('enquiry.thankyou')
            ->with('whatsapp_link', $whatsAppLink);
    }

    public function thankYou(): View
    {
        return view('public.pages.thank-you');
    }

    private function resolveDefaultOtaUrl(SettingsService $settings): ?string
    {
        $otaMode = $settings->get('ota_mode', 'both');
        $bookingCom = $settings->get('bookingcom_url');
        $airbnb = $settings->get('airbnb_url');

        if ($otaMode === 'bookingcom') {
            return $bookingCom ?: null;
        }

        if ($otaMode === 'airbnb') {
            return $airbnb ?: null;
        }

        return $bookingCom ?: ($airbnb ?: null);
    }
}
