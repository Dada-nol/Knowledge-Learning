<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
  public function __construct()
  {
    Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
  }

  public function createCheckoutSession(array $items, string $successUrl, string $cancelUrl)
  {
    return Session::create([
      'payment_method_types' => ['card'],
      'line_items' => [$items],
      'mode' => 'payment',
      'success_url' => $successUrl,
      'cancel_url' => $cancelUrl,
    ]);
  }
}
