<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\AccessCourseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class AccessCourse
 *
 * Represents the access control for a course associated with a user.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: AccessCourseRepository::class)]
#[HasLifecycleCallbacks]
class AccessCourse
{
    use Timestampable;

    /**
     * @var int|null The unique identifier for this access course.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var User|null The user associated with this access course.
     */
    #[ORM\ManyToOne(inversedBy: 'course')]
    private ?User $user = null;

    /**
     * @var Course|null The course associated with this access course.
     */
    #[ORM\ManyToOne(inversedBy: 'accessCourse')]
    private ?Course $course = null;

    /**
     * @var bool|null Indicates whether the course is available to the user.
     */
    #[ORM\Column]
    private ?bool $isAvailable = false;

    /**
     * Gets the ID of the access course.
     *
     * @return int|null The ID of the access course.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the user associated with this access course.
     *
     * @return User|null The user associated with this access course.
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Sets the user associated with this access course.
     *
     * @param User|null $user The user to associate with this access course.
     * @return static Returns the current instance for method chaining.
     */
    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets the course associated with this access course.
     *
     * @return Course|null The course associated with this access course.
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * Sets the course associated with this access course.
     *
     * @param Course|null $course The course to associate with this access course.
     * @return static Returns the current instance for method chaining.
     */
    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Checks if the course is available to the user.
     *
     * @return bool|null True if available, otherwise false.
     */
    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    /**
     * Sets the availability of the course for the user.
     *
     * @param bool $isAvailable Indicates whether the course is available.
     * @return static Returns the current instance for method chaining.
     */
    public function setAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}
