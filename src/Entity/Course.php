<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Course
 *
 * Represents a course that can be accessed by users.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    /**
     * @var int|null The unique identifier for this course.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null The title of the course.
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var string|null The content of the course.
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    /**
     * @var Lesson|null The lesson associated with this course.
     */
    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'course')]
    private ?Lesson $lesson = null;

    /**
     * @var Collection<int, AccessCourse> The access records for this course.
     */
    #[ORM\OneToMany(targetEntity: AccessCourse::class, mappedBy: 'course')]
    private Collection $accessCourse;

    public function __construct()
    {
        $this->accessCourse = new ArrayCollection();
    }

    /**
     * Gets the ID of the course.
     *
     * @return int|null The ID of the course.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the title of the course.
     *
     * @return string|null The title of the course.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets the title of the course.
     *
     * @param string $title The title to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the content of the course.
     *
     * @return string|null The content of the course.
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Sets the content of the course.
     *
     * @param string|null $content The content to set.
     * @return static Returns the current instance for method chaining.
     * @throws \InvalidArgumentException If the content exceeds the length limit.
     */
    public function setContent(?string $content): self
    {
        if (strlen($content) > 255) { // Limite de longueur
            throw new \InvalidArgumentException('Le contenu est trop long.');
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Gets the lesson associated with this course.
     *
     * @return Lesson|null The associated lesson.
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * Sets the lesson associated with this course.
     *
     * @param Lesson|null $lesson The lesson to associate with this course.
     * @return static Returns the current instance for method chaining.
     */
    public function setLesson(?Lesson $lesson): static
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Gets the access records for this course.
     *
     * @return Collection<int, AccessCourse> The collection of access records.
     */
    /**
     * @return Collection<int, AccessCourse>
     */
    public function getAccessCourse(): Collection
    {
        return $this->accessCourse;
    }

    /**
     * Adds an access record to this course.
     *
     * @param AccessCourse $accessCourse The access record to add.
     * @return static Returns the current instance for method chaining.
     */
    public function addAccessCourse(AccessCourse $accessCourse): static
    {
        if (!$this->accessCourse->contains($accessCourse)) {
            $this->accessCourse->add($accessCourse);
            $accessCourse->setCourse($this);
        }

        return $this;
    }

    /**
     * Removes an access record from this course.
     *
     * @param AccessCourse $userCourse The access record to remove.
     * @return static Returns the current instance for method chaining.
     */
    public function removeAccessCourse(AccessCourse $userCourse): static
    {
        if ($this->accessCourse->removeElement($userCourse)) {
            // set the owning side to null (unless already changed)
            if ($userCourse->getCourse() === $this) {
                $userCourse->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * Returns the string representation of the course.
     *
     * @return string The title of the course.
     */
    public function __toString(): string
    {
        return $this->getTitle();
    }
}
