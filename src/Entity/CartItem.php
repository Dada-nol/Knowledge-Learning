<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class CartItem
 *
 * Represents an item in the shopping cart.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: CartItemRepository::class)]
#[HasLifecycleCallbacks]
class CartItem
{
    use Timestampable;

    /**
     * @var int|null The unique identifier for this cart item.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Cart|null The cart to which this item belongs.
     */
    #[ORM\ManyToOne(inversedBy: 'cartItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $cart = null;

    /**
     * @var int|null The quantity of this item in the cart.
     */
    #[ORM\Column]
    private ?int $quantity = null;

    /**
     * @var Lesson|null The lesson associated with this cart item.
     */
    #[ORM\ManyToOne]
    private ?Lesson $lessons = null;

    /**
     * @var Cursus|null The cursus associated with this cart item.
     */
    #[ORM\ManyToOne]
    private ?Cursus $cursus = null;

    /**
     * Gets the ID of the cart item.
     *
     * @return int|null The ID of the cart item.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the cart associated with this item.
     *
     * @return Cart|null The cart associated with this item.
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * Sets the cart associated with this item.
     *
     * @param Cart|null $cart The cart to associate with this item.
     * @return static Returns the current instance for method chaining.
     */
    public function setCart(?Cart $cart): static
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Gets the quantity of this item in the cart.
     *
     * @return int|null The quantity of this item.
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity of this item in the cart.
     *
     * @param int $quantity The quantity to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Gets the lesson associated with this cart item.
     *
     * @return Lesson|null The associated lesson.
     */
    public function getLessons(): ?Lesson
    {
        return $this->lessons;
    }

    /**
     * Sets the lesson associated with this cart item.
     *
     * @param Lesson|null $lessons The lesson to associate with this item.
     * @return static Returns the current instance for method chaining.
     */
    public function setLessons(?Lesson $lessons): static
    {
        $this->lessons = $lessons;

        return $this;
    }

    /**
     * Gets the cursus associated with this cart item.
     *
     * @return Cursus|null The associated cursus.
     */
    public function getCursus(): ?Cursus
    {
        return $this->cursus;
    }

    /**
     * Sets the cursus associated with this cart item.
     *
     * @param Cursus|null $cursus The cursus to associate with this item.
     * @return static Returns the current instance for method chaining.
     */
    public function setCursus(?Cursus $cursus): static
    {
        $this->cursus = $cursus;

        return $this;
    }
}
