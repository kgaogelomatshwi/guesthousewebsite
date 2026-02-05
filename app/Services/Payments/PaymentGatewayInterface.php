<?php

namespace App\Services\Payments;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function initiatePayment(Booking $booking): RedirectResponse|array;

    public function handleCallback(Request $request): array;
}
