<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ExternalBooking;
use Illuminate\View\View;

class GuestDashboardController extends Controller
{
    public function index(): View
    {
        $user = request()->user();

        $bookings = Booking::query()
            ->with('room')
            ->where(function ($query) use ($user): void {
                $query->where('created_by', $user->id)
                    ->orWhere('email', $user->email);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $externalBookings = ExternalBooking::query()
            ->where('email', $user->email)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'external_page');

        return view('public.guest.dashboard', compact('bookings', 'externalBookings'));
    }
}
