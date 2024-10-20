<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
  /**
   * @Route("/checkout", name="checkout")
   */
  public function checkout()
  {
    return $this->render('payment/checkout.html.twig', [
      'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
    ]);
  }
}
