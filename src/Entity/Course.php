<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Lesson $lesson = null;

    /**
     * @var Collection<int, UserCourse>
     */
    #[ORM\OneToMany(targetEntity: UserCourse::class, mappedBy: 'course')]
    private Collection $userCourse;

    public function __construct()
    {
        $this->userCourse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): static
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * @return Collection<int, UserCourse>
     */
    public function getUserCourse(): Collection
    {
        return $this->userCourse;
    }

    public function addUserCourse(UserCourse $userCourse): static
    {
        if (!$this->userCourse->contains($userCourse)) {
            $this->userCourse->add($userCourse);
            $userCourse->setCourse($this);
        }

        return $this;
    }

    public function removeUserCourse(UserCourse $userCourse): static
    {
        if ($this->userCourse->removeElement($userCourse)) {
            // set the owning side to null (unless already changed)
            if ($userCourse->getCourse() === $this) {
                $userCourse->setCourse(null);
            }
        }

        return $this;
    }
}
