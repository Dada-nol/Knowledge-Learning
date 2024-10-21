<?php

namespace App\Controller;

use App\Entity\AccessCourse;
use App\Entity\Cart;
use App\Entity\User;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
  #[Route('/checkout', name: 'checkout')]
  public function checkout(EntityManagerInterface $entityManager, Security $security, StripeService $stripeService): Response
  {
    $user = $security->getUser();
    $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user' => $user]);

    if ($user instanceof User) {
      $userName = $user->getEmail();
    } else {
      $userName = 'Utilisateur inconnu';
    }


    $lineItems = [[
      'price_data' => [
        'currency' => 'eur',
        'product_data' => [
          'name' => 'Panier de' . ' ' . $userName,
        ],
        'unit_amount' => 5000,
      ],
      'quantity' => 1,
    ]];

    $checkoutSession = $stripeService->createCheckoutSession(
      $lineItems,
      $this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
      $this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL)
    );


    return $this->redirect($checkoutSession->url, 201);
  }

  #[Route('/payment/success', name: 'payment_success')]
  public function paymentSuccess(Security $security, EntityManagerInterface $entityManager): Response
  {
    $user = $security->getUser();
    $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user' => $user]);
    $cartItems = $cart->getCartItems();

    /* foreach ($cartItems as $item) {
      $stock = $item->getStock();
      $quantityPurchased = $item->getQuantity();

      if ($stock) {

        $stock->setQuantity($stock->getQuantity() - $quantityPurchased);
        $entityManager->persist($stock);
      }
      $entityManager->remove($item);
    } */


    $entityManager->flush();

    foreach ($cartItems as $item) {
      $accessCourse = $entityManager->getRepository(AccessCourse::class)->findOneBy([
        'user' => $user,
        'course' => $item->getLessons()->getCourse(),
      ]);

      if ($accessCourse) {
        $accessCourse->setAvailable(true); // Débloquer l'accès
        $entityManager->persist($accessCourse);
      } else {
        $accessCourse = new AccessCourse();
        $accessCourse->setUser($user);
        $accessCourse->setCourse($item->getLessons()->getCourse());
        $accessCourse->setAvailable(true);
        $entityManager->persist($accessCourse);
      }
    }

    $entityManager->flush();

    return $this->render('payment/success.html.twig');
  }

  #[Route('/payment/cancel', name: 'payment_cancel')]
  public function paymentCancel(): Response
  {
    return $this->render('payment/cancel.html.twig');
  }
}
