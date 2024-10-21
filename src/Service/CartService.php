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
  private $user;
  private $lesson;

  public function __construct(EntityManagerInterface $em, Security $security, Lesson $lesson)
  {
    $this->em = $em;
    $this->user = $security->getUser();
    $this->lesson = $lesson;
  }

  public function getCartItems()
  {
    $cart = $this->em->getRepository(Cart::class)->findOneBy(['user' => $this->user]);

    return $this->em->getRepository(CartItem::class)->findBy(['cart' => $cart, 'lesson' => $this->lesson]);
  }

  public function addToCart()
  {
    $cart = $this->em->getRepository(Cart::class)->findOneBy(['user' => $this->user]);
    $cartItem = $this->em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'lesson' => $this->lesson]);

    if (!$cart) {
      $cart = new Cart($this->user);
      $this->em->persist($cart);
    }

    if ($cartItem) {
      $cartItem->setQuantity($cartItem->getQuantity() + 1);
    } else {

      $cartItem = new CartItem();
      $cartItem->setLessons($this->lesson);
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

  public function clearCart()
  {
    $cartItems = $this->getCartItems();

    foreach ($cartItems as $item) {
      $this->em->remove($item);
    }

    $this->em->flush();
  }
}
