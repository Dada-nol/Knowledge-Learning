<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class Cart
 *
 * Represents a shopping cart associated with a user.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: CartRepository::class)]
#[HasLifecycleCallbacks]
class Cart
{
    use Timestampable;

    /**
     * @var int|null The unique identifier for this cart.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var User|null The user associated with this cart.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    /**
     * @var Collection<int, CartItem> The items in the cart.
     */
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart', orphanRemoval: true)]
    private Collection $cartItems;

    /**
     * Cart constructor.
     * Initializes the cart items collection.
     */
    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    /**
     * Gets the ID of the cart.
     *
     * @return int|null The ID of the cart.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the user associated with this cart.
     *
     * @return User|null The user associated with this cart.
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Sets the user associated with this cart.
     *
     * @param User|null $user The user to associate with this cart.
     * @return static Returns the current instance for method chaining.
     */
    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets the collection of cart items.
     *
     * @return Collection<int, CartItem> The items in the cart.
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    /**
     * Adds a cart item to the cart.
     *
     * @param CartItem $cartItem The cart item to add.
     * @return static Returns the current instance for method chaining.
     */
    public function addCartItem(CartItem $cartItem): static
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems->add($cartItem);
            $cartItem->setCart($this);
        }

        return $this;
    }

    /**
     * Removes a cart item from the cart.
     *
     * @param CartItem $cartItem The cart item to remove.
     * @return static Returns the current instance for method chaining.
     */
    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }

        return $this;
    }

    /**
     * Calculates the total price of the items in the cart.
     *
     * @return float The total price of the items in the cart.
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getCartItems() as $item) {
            if ($item->getLessons()) {
                $total += $item->getLessons()->getPrice() * $item->getQuantity();
            } elseif ($item->getCursus()) {
                $total += $item->getCursus()->getPrice() * $item->getQuantity();
            }
        }

        return $total;
    }
}
