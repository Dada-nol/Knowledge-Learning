<?php

namespace App\Service;

use Stripe\Checkout\Session;
use Stripe\Stripe;

/**
 * Service StripeService : Gère les interactions avec l'API Stripe pour créer des sessions de paiement.
 */
class StripeService
{
  private string $stripeApiKey;

  public function __construct(string $stripeApiKey)
  {
    $this->stripeApiKey = $stripeApiKey;
  }

  /**
   * Crée une session de paiement Stripe Checkout.
   *
   * @param array $lineItems Les éléments du panier à facturer dans la session de paiement.
   * @param string $successUrl L'URL vers laquelle l'utilisateur sera redirigé en cas de paiement réussi.
   * @param string $cancelUrl L'URL vers laquelle l'utilisateur sera redirigé en cas d'annulation du paiement.
   * 
   * @return Session La session de paiement Stripe créée.
   */
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
