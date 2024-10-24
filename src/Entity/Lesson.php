<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class Lesson
 *
 * Represents a lesson within a cursus, which may include associated courses and certificates.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: LessonRepository::class)]
#[HasLifecycleCallbacks]
class Lesson
{
    use Timestampable;

    /**
     * @var int|null The unique identifier for this lesson.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null The name of the lesson.
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var int|null The price associated with the lesson.
     */
    #[ORM\Column]
    private ?int $price = null;

    /**
     * @var Cursus|null The cursus that this lesson belongs to.
     */
    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cursus $cursus = null;

    /**
     * @var Collection<int, Course> The courses associated with this lesson.
     */
    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: "lesson", cascade: ["persist", "remove"])]
    private $course;

    /**
     * @var Collection<int, Certificate> The certificates associated with this lesson.
     */
    #[ORM\OneToMany(targetEntity: Certificate::class, mappedBy: 'lesson')]
    private Collection $certificates;

    public function __construct()
    {
        $this->certificates = new ArrayCollection();
    }

    /**
     * Gets the associated courses for this lesson.
     *
     * @return mixed The associated courses.
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Sets the course for this lesson.
     *
     * @param Course $course The course to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setCourse(Course $course): self
    {
        $this->course = $course;

        if ($course !== null && $course->getLesson() !== $this) {
            $course->setLesson($this);
        }

        return $this;
    }

    /**
     * Gets the ID of the lesson.
     *
     * @return int|null The ID of the lesson.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the name of the lesson.
     *
     * @return string|null The name of the lesson.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name of the lesson.
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
     * Gets the price of the lesson.
     *
     * @return int|null The price of the lesson.
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Sets the price of the lesson.
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
     * Gets the cursus that this lesson belongs to.
     *
     * @return Cursus|null The associated cursus.
     */
    public function getCursus(): ?Cursus
    {
        return $this->cursus;
    }

    /**
     * Sets the cursus for this lesson.
     *
     * @param Cursus|null $cursus The cursus to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setCursus(?Cursus $cursus): static
    {
        $this->cursus = $cursus;

        return $this;
    }

    /**
     * Returns the string representation of the lesson.
     *
     * @return string The name of the lesson.
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Gets the certificates associated with this lesson.
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
     * Adds a certificate to this lesson.
     *
     * @param Certificate $certificate The certificate to add.
     * @return static Returns the current instance for method chaining.
     */
    public function addCertificate(Certificate $certificate): static
    {
        if (!$this->certificates->contains($certificate)) {
            $this->certificates->add($certificate);
            $certificate->setLesson($this);
        }

        return $this;
    }

    /**
     * Removes a certificate from this lesson.
     *
     * @param Certificate $certificate The certificate to remove.
     * @return static Returns the current instance for method chaining.
     */
    public function removeCertificate(Certificate $certificate): static
    {
        if ($this->certificates->removeElement($certificate)) {
            // set the owning side to null (unless already changed)
            if ($certificate->getLesson() === $this) {
                $certificate->setLesson(null);
            }
        }

        return $this;
    }
}
