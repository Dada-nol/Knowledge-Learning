<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Lesson;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{

  private $cartService;

  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  #[Route('/cart', name: 'cart')]
  public function showCart(EntityManagerInterface $entityManager, Security $security): Response
  {
    $user = $security->getUser();
    $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user' => $user]);
    $items = $cart->getCartItems();

    $deleteForms = [];
    if ($items) {
      foreach ($items as $item) {
        $deleteForms[$item->getId()] = $this->createFormBuilder()
          ->setAction($this->generateUrl('deleteItem', ['id' => $item->getId()]))
          ->setMethod('DELETE')
          ->getForm()
          ->createView();
      }
    }

    return $this->render('cart/index.html.twig', ['items' => $items, 'cart' => $cart, 'deleteForms' => $deleteForms]);
  }

  #[Route('/cart/add/{id}', name: 'cart_add')]
  public function addToCart(EntityManagerInterface $entityManager, int $id): Response
  {
    $lesson = $entityManager->getRepository(Lesson::class)->find($id);
    $this->cartService->addToCart($lesson);

    return $this->redirectToRoute('cart');
  }

  #[Route('/cart/deleteItem/{id}', name: 'deleteItem')]
  public function deleteItem(EntityManagerInterface $entityManager, int $id): Response
  {
    $cartItem = $entityManager->getRepository(CartItem::class)->find($id);

    if (!$cartItem) {
      throw $this->createNotFoundException('Item not found');
    }

    $entityManager->remove($cartItem);
    $entityManager->flush();

    return $this->redirectToRoute('cart');
  }
}
