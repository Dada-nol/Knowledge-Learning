<?php

namespace App\Entity;

use App\Repository\CursusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cursus
 *
 * Represents a cursus (course structure) that can contain lessons and certificates.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: CursusRepository::class)]
class Cursus
{
    /**
     * @var int|null The unique identifier for this cursus.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null The name of the cursus.
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var int|null The price of the cursus.
     */
    #[ORM\Column]
    private ?int $price = null;

    /**
     * @var Theme|null The theme associated with this cursus.
     */
    #[ORM\ManyToOne(inversedBy: 'cursus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Theme $theme = null;

    /**
     * @var Collection<int, Lesson> The lessons included in this cursus.
     */
    #[ORM\OneToMany(targetEntity: Lesson::class, mappedBy: 'cursus', orphanRemoval: true)]
    private Collection $lessons;

    /**
     * @var Collection<int, Certificate> The certificates associated with this cursus.
     */
    #[ORM\OneToMany(targetEntity: Certificate::class, mappedBy: 'cursus')]
    private Collection $certificates;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->certificates = new ArrayCollection();
    }

    /**
     * Gets the ID of the cursus.
     *
     * @return int|null The ID of the cursus.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the name of the cursus.
     *
     * @return string|null The name of the cursus.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name of the cursus.
     *
     * @param string $name The name to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the price of the cursus.
     *
     * @return int|null The price of the cursus.
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Sets the price of the cursus.
     *
     * @param int $price The price to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Gets the theme associated with this cursus.
     *
     * @return Theme|null The associated theme.
     */
    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    /**
     * Sets the theme associated with this cursus.
     *
     * @param Theme|null $theme The theme to associate with this cursus.
     * @return static Returns the current instance for method chaining.
     */
    public function setTheme(?Theme $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Gets the lessons included in this cursus.
     *
     * @return Collection<int, Lesson> The collection of lessons.
     */
    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    /**
     * Adds a lesson to this cursus.
     *
     * @param Lesson $lesson The lesson to add.
     * @return static Returns the current instance for method chaining.
     */
    public function addLesson(Lesson $lesson): static
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setCursus($this);
        }

        return $this;
    }

    /**
     * Removes a lesson from this cursus.
     *
     * @param Lesson $lesson The lesson to remove.
     * @return static Returns the current instance for method chaining.
     */
    public function removeLesson(Lesson $lesson): static
    {
        if ($this->lessons->removeElement($lesson)) {
            if ($lesson->getCursus() === $this) {
                $lesson->setCursus(null);
            }
        }

        return $this;
    }

    /**
     * Returns the string representation of the cursus.
     *
     * @return string The name of the cursus.
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Gets the names of lessons in the cursus as a comma-separated string.
     *
     * @return string The lesson names.
     */
    public function getLessonsAsString(): string
    {
        $lessonNames = $this->lessons->map(fn($lesson) => $lesson->getName())->toArray();
        return implode(', ', $lessonNames);
    }

    /**
     * Gets the certificates associated with this cursus.
     *
     * @return Collection<int, Certificate> The collection of certificates.
     */
    /**
     * @return Collection<int, Certificate>
     */
    public function getCertificates(): Collection
    {
        return $this->certificates;
    }

    /**
     * Adds a certificate to this cursus.
     *
     * @param Certificate $certificate The certificate to add.
     * @return static Returns the current instance for method chaining.
     */
    public function addCertificate(Certificate $certificate): static
    {
        if (!$this->certificates->contains($certificate)) {
            $this->certificates->add($certificate);
            $certificate->setCursus($this);
        }

        return $this;
    }

    /**
     * Removes a certificate from this cursus.
     *
     * @param Certificate $certificate The certificate to remove.
     * @return static Returns the current instance for method chaining.
     */
    public function removeCertificate(Certificate $certificate): static
    {
        if ($this->certificates->removeElement($certificate)) {
            // set the owning side to null (unless already changed)
            if ($certificate->getCursus() === $this) {
                $certificate->setCursus(null);
            }
        }

        return $this;
    }
}
