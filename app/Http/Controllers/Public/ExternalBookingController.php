<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ExternalBooking;
use Illuminate\Http\RedirectResponse;

class ExternalBookingController extends Controller
{
    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'platform' => ['required', 'string', 'max:50'],
            'booking_reference' => ['required', 'string', 'max:100'],
            'check_in' => ['nullable', 'date'],
            'check_out' => ['nullable', 'date', 'after_or_equal:check_in'],
            'guests' => ['nullable', 'integer', 'min:1'],
            'room_type' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
        ]);

        ExternalBooking::create($data);

        return back()->with('success', 'Thanks! We have logged your booking details.');
    }
}
