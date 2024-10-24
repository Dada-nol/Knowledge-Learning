<?php

namespace App\Tests;

use App\Entity\Lesson;
use App\Service\StripeService;
use PHPUnit\Framework\TestCase;
use Stripe\Checkout\Session;

class StripeServiceTest extends TestCase
{
  private StripeService $stripeService;

  protected function setUp(): void
  {
    $this->stripeService = new StripeService('sk_test_51QCQxuRskVqAEQvDJ3D173OhpQpeDFznkJkWw90VhwMdpi7EyL0Z75d1DyLrdCFGY8ZqcR9Iyi7DcD2PxBsgdvX900o9TwlOqQ'); // Remplace par une clé de test valide
  }

  public function testCreateCheckoutSessionForLesson()
  {
    $lesson = new Lesson();
    $lesson->setName('Test Lesson');
    $lesson->setPrice(50);

    $lineItems = [[
      'price_data' => [
        'currency' => 'usd',
        'product_data' => [
          'name' => $lesson->getName(),
        ],
        'unit_amount' => $lesson->getPrice() * 100,
      ],
      'quantity' => 1,
    ]];

    $successUrl = 'https://example.com/success';
    $cancelUrl = 'https://example.com/cancel';

    $session = $this->stripeService->createCheckoutSession($lineItems, $successUrl, $cancelUrl);

    $this->assertInstanceOf(Session::class, $session);
    $this->assertSame('https://example.com/success', $session->success_url);
    $this->assertSame('https://example.com/cancel', $session->cancel_url);
    $this->assertNotEmpty($session->id);
  }
}
