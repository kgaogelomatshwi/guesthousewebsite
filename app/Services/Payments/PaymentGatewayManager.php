<?php

namespace App\Services\Payments;

class PaymentGatewayManager
{
    public function resolve(string $provider): PaymentGatewayInterface
    {
        return match (strtolower($provider)) {
            'payfast' => new PayFastGateway(),
            'ozow' => new OzowGateway(),
            'peach', 'peach_payments' => new PeachPaymentsGateway(),
            'stripe' => new StripeGateway(),
            default => new StubGateway(),
        };
    }
}
