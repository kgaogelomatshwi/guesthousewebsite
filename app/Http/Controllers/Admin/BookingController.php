<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with('room')->orderByDesc('created_at')->paginate(20);

        $month = request('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $calendarBookings = Booking::query()
            ->whereDate('check_in', '<=', $end)
            ->whereDate('check_out', '>=', $start)
            ->get();

        return view('admin.bookings.index', compact('bookings', 'month', 'start', 'end', 'calendarBookings'));
    }

    public function create(): View
    {
        $rooms = Room::orderBy('title')->get();

        return view('admin.bookings.create', compact('rooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);

        $data['code'] = strtoupper(substr(sha1(uniqid('', true)), 0, 8));
        $data['created_by'] = $request->user()->id;
        $data['source'] = 'admin';

        $booking = Booking::create($data);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking created.');
    }

    public function show(Booking $booking): View
    {
        $booking->load('room', 'payments');

        return view('admin.bookings.show', compact('booking'));
    }

    public function export(): Response
    {
        $bookings = Booking::orderByDesc('created_at')->get();

        $lines = [];
        $lines[] = 'id,code,guest_name,email,phone,check_in,check_out,guests,room_id,status,total_amount,currency,created_at';
        foreach ($bookings as $booking) {
            $lines[] = implode(',', [
                $booking->id,
                $booking->code,
                $this->escape($booking->guest_name),
                $this->escape($booking->email),
                $this->escape($booking->phone),
                $booking->check_in,
                $booking->check_out,
                $booking->guests,
                $booking->room_id,
                $booking->status,
                $booking->total_amount,
                $booking->currency,
                $booking->created_at,
            ]);
        }

        $csv = implode("\n", $lines);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bookings.csv"',
        ]);
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
        ]);

        $booking->update(['status' => $data['status']]);

        return back()->with('success', 'Status updated.');
    }

    private function escape(?string $value): string
    {
        $value = (string) $value;
        $value = str_replace('"', '""', $value);
        return '"' . $value . '"';
    }
}
