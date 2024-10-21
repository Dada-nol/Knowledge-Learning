<?php

namespace App\Service;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService
{
  private string $stripeApiKey;

  public function __construct(string $stripeApiKey)
  {
    $this->stripeApiKey = $stripeApiKey;
  }

  public function createCheckoutSession(array $lineItems, string $successUrl, string $cancelUrl): Session
  {
    Stripe::setApiKey($this->stripeApiKey);

    return Session::create([
      'payment_method_types' => ['card'],
      'line_items' => $lineItems,
      'mode' => 'payment',
      'success_url' => $successUrl,
      'cancel_url' => $cancelUrl,
    ]);
  }
}
