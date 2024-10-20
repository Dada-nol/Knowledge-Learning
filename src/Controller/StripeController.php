<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
  private $stripeService;

  public function __construct(StripeService $stripeService)
  {
    $this->stripeService = $stripeService;
  }

  /**
   * @Route("/create-checkout-session", name="create_checkout_session", methods={"POST"})
   */
  public function createCheckoutSession(): JsonResponse
  {
    $items = [
      [
        'price_data' => [
          'currency' => 'usd',
          'product_data' => [
            'name' => 'Cours Symfony',
          ],
          'unit_amount' => 2000, // en centimes (donc 20 USD ici)
        ],
        'quantity' => 1,
      ]
    ];

    $checkoutSession = $this->stripeService->createCheckoutSession(
      $items,
      $this->generateUrl('checkout_success', [], 0),
      $this->generateUrl('checkout_cancel', [], 0)
    );

    return new JsonResponse(['id' => $checkoutSession->id]);
  }

  /**
   * @Route("/checkout-success", name="checkout_success")
   */
  public function checkoutSuccess()
  {
    return $this->render('checkout/success.html.twig');
  }

  /**
   * @Route("/checkout-cancel", name="checkout_cancel")
   */
  public function checkoutCancel()
  {
    return $this->render('checkout/cancel.html.twig');
  }
}
