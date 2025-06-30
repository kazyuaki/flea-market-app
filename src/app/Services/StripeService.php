<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function createCheckoutSession($data)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Session::create($data);
    }
}

?>