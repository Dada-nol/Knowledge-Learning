<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Lesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CartService
{
  private $em;
  private $security;

  public function __construct(EntityManagerInterface $em, Security $security)
  {
    $this->em = $em;
    $this->security = $security;
  }

  public function getCartItems(Lesson $lesson)
  {

    $user = $this->security->getUser();

    if (!$user) {
      throw new \Exception("L'utilisateur n'est pas connecté.");
    }

    $cart = $this->em->getRepository(Cart::class)->findOneBy(['user' => $user]);

    return $this->em->getRepository(CartItem::class)->findBy(['cart' => $cart, 'lesson' => $lesson]);
  }

  public function addToCart(Lesson $lesson)
  {

    $user = $this->security->getUser();

    if (!$user) {
      throw new \Exception("L'utilisateur n'est pas connecté.");
    }

    $cart = $this->em->getRepository(Cart::class)->findOneBy(['user' => $user]);
    $cartItem = $this->em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'lessons' => $lesson]);

    if (!$cart) {
      $cart = new Cart();
      $cart->setUser($user);
      $this->em->persist($cart);
    }

    if ($cartItem) {
      $cartItem->setQuantity($cartItem->getQuantity() + 1);
    } else {

      $cartItem = new CartItem();
      $cartItem->setLessons($lesson);
      $cartItem->setQuantity(1);
      $cartItem->setCart($cart);
      $this->em->persist($cartItem);
    }

    $this->em->flush();
  }

  public function removeFromCart(CartItem $cartItem)
  {
    $this->em->remove($cartItem);
    $this->em->flush();
  }

  /* public function clearCart()
  {
    $cartItems = $this->getCartItems();

    foreach ($cartItems as $item) {
      $this->em->remove($item);
    }

    $this->em->flush();
  } */
}
