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
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'course')]
    private ?Lesson $lesson = null;

    /**
     * @var Collection<int, AccessCourse>
     */
    #[ORM\OneToMany(targetEntity: AccessCourse::class, mappedBy: 'course')]
    private Collection $accessCourse;

    public function __construct()
    {
        $this->accessCourse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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
     * @return Collection<int, AccessCourse>
     */
    public function getAccessCourse(): Collection
    {
        return $this->accessCourse;
    }

    public function addAccessCourse(AccessCourse $accessCourse): static
    {
        if (!$this->accessCourse->contains($accessCourse)) {
            $this->accessCourse->add($accessCourse);
            $accessCourse->setCourse($this);
        }

        return $this;
    }

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

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
