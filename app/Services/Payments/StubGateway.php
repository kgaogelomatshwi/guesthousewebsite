<?php

namespace App\Services\Payments;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StubGateway implements PaymentGatewayInterface
{
    public function initiatePayment(Booking $booking): RedirectResponse|array
    {
        return redirect()->route('booking.thankyou')->with('booking_code', $booking->code);
    }

    public function handleCallback(Request $request): array
    {
        return [
            'status' => 'succeeded',
        ];
    }
}
