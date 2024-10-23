<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Cursus;
use App\Entity\Lesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;


/**
 * Service CartService : Gère les opérations liées au panier d'achat, comme l'ajout de leçons ou de cursus au panier, et la gestion des éléments du panier.
 */
class CartService
{
  private $em;
  private $security;

  public function __construct(EntityManagerInterface $em, Security $security)
  {
    $this->em = $em;
    $this->security = $security;
  }

  /**
   * Récupère les items dans le panier de l'utilisateur en fonction d'une leçon donnée.
   *
   * @param Lesson $lesson La leçon à chercher dans le panier.
   * @return CartItem[] Les items du panier correspondant à la leçon.
   * @throws \Exception Si l'utilisateur n'est pas connecté.
   */
  public function getCartItems(Lesson $lesson)
  {

    $user = $this->security->getUser();

    if (!$user) {
      throw new \Exception("L'utilisateur n'est pas connecté.");
    }

    $cart = $this->em->getRepository(Cart::class)->findOneBy(['user' => $user]);

    return $this->em->getRepository(CartItem::class)->findBy(['cart' => $cart, 'lesson' => $lesson]);
  }


  /**
   * Ajoute une leçon au panier de l'utilisateur connecté.
   *
   * @param Lesson $lesson La leçon à ajouter au panier.
   * @throws \Exception Si l'utilisateur n'est pas connecté.
   */
  public function addLessonToCart(Lesson $lesson)
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


  /**
   * Ajoute un cursus entier au panier de l'utilisateur connecté.
   *
   * @param Cursus $cursus Le cursus à ajouter au panier.
   * @throws \Exception Si l'utilisateur n'est pas connecté.
   */
  public function addCursusToCart(Cursus $cursus)
  {

    $user = $this->security->getUser();

    if (!$user) {
      throw new \Exception("L'utilisateur n'est pas connecté.");
    }

    $cart = $this->em->getRepository(Cart::class)->findOneBy(['user' => $user]);
    $cartItem = $this->em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'cursus' => $cursus]);


    if (!$cart) {
      $cart = new Cart();
      $cart->setUser($user);
      $this->em->persist($cart);
    }

    if ($cartItem) {
      $cartItem->setQuantity($cartItem->getQuantity() + 1);
    } else {

      $cartItem = new CartItem();
      $cartItem->setCursus($cursus);
      $cartItem->setQuantity(1);
      $cartItem->setCart($cart);
      $this->em->persist($cartItem);
    }

    $this->em->flush();
  }


  /**
   * Supprime un item du panier.
   *
   * @param CartItem $cartItem L'item du panier à supprimer.
   */
  public function removeFromCart(CartItem $cartItem)
  {
    $this->em->remove($cartItem);
    $this->em->flush();
  }
}
