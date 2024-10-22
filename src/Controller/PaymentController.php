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

    $entityManager->flush();

    foreach ($cartItems as $item) {
      $lesson = $item->getLessons();

      if ($lesson) {
        $courses = $lesson->getCourse();

        if (!$courses || $courses->isEmpty()) {
          continue;
        }

        $course = $courses->first();

        $accessCourse = $entityManager->getRepository(AccessCourse::class)->findOneBy([
          'user' => $user,
          'course' => $course,
        ]);

        if ($accessCourse) {
          $accessCourse->setAvailable(true);
          $entityManager->persist($accessCourse);
        } else {
          $accessCourse = new AccessCourse();
          $accessCourse->setUser($user);
          $accessCourse->setCourse($course);
          $accessCourse->setAvailable(true);
          $entityManager->persist($accessCourse);
        }
      } else {
        $cursus = $item->getCursus();

        if ($cursus) {
          $cursusLessons = $cursus->getLessons();

          foreach ($cursusLessons as $cursusLesson) {
            $cursusCourses = $cursusLesson->getCourse();

            if (!$cursusCourses || $cursusCourses->isEmpty()) {
              continue;
            }

            $cursusCourse = $cursusCourses->first();

            $accessCourse = $entityManager->getRepository(AccessCourse::class)->findOneBy([
              'user' => $user,
              'course' => $cursusCourse,
            ]);

            if ($accessCourse) {
              $accessCourse->setAvailable(true);
              $entityManager->persist($accessCourse);
            } else {
              $accessCourse = new AccessCourse();
              $accessCourse->setUser($user);
              $accessCourse->setCourse($cursusCourse);
              $accessCourse->setAvailable(true);
              $entityManager->persist($accessCourse);
            }
          }
        }
      }

      $entityManager->remove($item);
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
