<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Cursus;
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

  /**
   * CartController constructor.
   * 
   * @param CartService $cartService The service used to manage cart operations.
   */
  public function __construct(CartService $cartService)
  {
    $this->cartService = $cartService;
  }

  /**
   * Displays the user's cart along with items and delete forms.
   *
   * @Route('/cart', name='cart')
   * @param EntityManagerInterface $entityManager The entity manager for database operations.
   * @param Security $security The security service to get the current user.
   * @return Response The response containing the rendered cart page.
   */
  #[Route('/cart', name: 'cart')]
  public function showCart(EntityManagerInterface $entityManager, Security $security): Response
  {
    $user = $security->getUser();
    $cart = $entityManager->getRepository(Cart::class)->findOneBy(['user' => $user]);

    if ($cart) {
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
    } else {
      return $this->redirectToRoute('app_theme');
    }

    return $this->render('cart/index.html.twig', ['items' => $items, 'cart' => $cart, 'deleteForms' => $deleteForms]);
  }

  /**
   * Adds a lesson to the user's cart.
   *
   * @Route('/cart/addLesson/{id}', name: 'cart_addLesson')
   * @param EntityManagerInterface $entityManager The entity manager for database operations.
   * @param int $id The ID of the lesson to add.
   * @return Response A redirect response to the cart page.
   */
  #[Route('/cart/addLesson/{id}', name: 'cart_addLesson')]
  public function addLessonToCart(EntityManagerInterface $entityManager, int $id): Response
  {
    $lesson = $entityManager->getRepository(Lesson::class)->find($id);
    $this->cartService->addLessonToCart($lesson);

    return $this->redirectToRoute('cart');
  }

  /**
   * Adds a cursus to the user's cart.
   *
   * @Route('/cart/addCursus/{id}', name: 'cart_addCursus')
   * @param EntityManagerInterface $entityManager The entity manager for database operations.
   * @param int $id The ID of the cursus to add.
   * @return Response A redirect response to the cart page.
   */
  #[Route('/cart/addCursus/{id}', name: 'cart_addCursus')]
  public function addCursusToCart(EntityManagerInterface $entityManager, int $id): Response
  {
    $cursus = $entityManager->getRepository(Cursus::class)->find($id);
    $this->cartService->addCursusToCart($cursus);

    return $this->redirectToRoute('cart');
  }

  /**
   * Deletes an item from the user's cart.
   *
   * @Route('/cart/deleteItem/{id}', name='deleteItem')
   * @param EntityManagerInterface $entityManager The entity manager for database operations.
   * @param int $id The ID of the cart item to delete.
   * @return Response A redirect response to the cart page.
   * @throws \NotFoundHttpException if the cart item is not found.
   */
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
