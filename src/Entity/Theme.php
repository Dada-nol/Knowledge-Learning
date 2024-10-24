<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class Theme
 *
 * Represents a theme under which multiple cursus can be categorized.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[HasLifecycleCallbacks]

class Theme
{
    use Timestampable;

    /**
     * @var int|null The unique identifier for the theme.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null The name of the theme.
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Cursus> A collection of cursus associated with this theme.
     */
    #[ORM\OneToMany(targetEntity: Cursus::class, mappedBy: 'theme')]
    private Collection $cursus;

    public function __construct()
    {
        $this->cursus = new ArrayCollection();
    }

    /**
     * Gets the ID of the theme.
     *
     * @return int|null The ID of the theme.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the name of the theme.
     *
     * @return string|null The name of the theme.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name of the theme.
     *
     * @param string $name The name to set for the theme.
     * @return static The current instance.
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Converts the theme to a string representation.
     *
     * @return string The name of the theme.
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Gets the collection of cursus associated with this theme.
     *
     * @return Collection<int, Cursus> The collection of cursus.
     */
    public function getCursus(): Collection
    {
        return $this->cursus;
    }
}
