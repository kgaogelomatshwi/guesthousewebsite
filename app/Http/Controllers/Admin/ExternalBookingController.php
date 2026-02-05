<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalBooking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ExternalBookingController extends Controller
{
    public function index(): View
    {
        $bookings = ExternalBooking::orderByDesc('created_at')->paginate(20);

        return view('admin.external-bookings.index', compact('bookings'));
    }

    public function show(ExternalBooking $externalBooking): View
    {
        return view('admin.external-bookings.show', ['booking' => $externalBooking]);
    }

    public function updateStatus(Request $request, ExternalBooking $externalBooking): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
        ]);

        $externalBooking->update(['status' => $data['status']]);

        return back()->with('success', 'Status updated.');
    }

    public function export(): Response
    {
        $bookings = ExternalBooking::orderByDesc('created_at')->get();

        $lines = [];
        $lines[] = 'id,full_name,email,phone,platform,booking_reference,check_in,check_out,guests,room_type,status,created_at';
        foreach ($bookings as $booking) {
            $lines[] = implode(',', [
                $booking->id,
                $this->escape($booking->full_name),
                $this->escape($booking->email),
                $this->escape($booking->phone),
                $this->escape($booking->platform),
                $this->escape($booking->booking_reference),
                $booking->check_in,
                $booking->check_out,
                $booking->guests,
                $this->escape($booking->room_type),
                $booking->status,
                $booking->created_at,
            ]);
        }

        $csv = implode("\n", $lines);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="external_bookings.csv"',
        ]);
    }

    private function escape(?string $value): string
    {
        $value = (string) $value;
        $value = str_replace('"', '""', $value);
        return '"' . $value . '"';
    }
}
