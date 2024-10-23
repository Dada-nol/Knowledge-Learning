<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Certificate
 *
 * Represents a certificate awarded to a user for completing a cursus or lesson.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: CertificateRepository::class)]
class Certificate
{
    /**
     * @var int|null The unique identifier for this certificate.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Cursus|null The cursus associated with this certificate.
     */
    #[ORM\ManyToOne(inversedBy: 'certificates')]
    private ?Cursus $cursus = null;

    /**
     * @var Lesson|null The lesson associated with this certificate.
     */
    #[ORM\ManyToOne(inversedBy: 'certificates')]
    private ?Lesson $lesson = null;

    /**
     * @var User|null The user who earned this certificate.
     */
    #[ORM\ManyToOne(inversedBy: 'certificates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var bool|null Indicates whether the certificate is certified.
     */
    #[ORM\Column]
    private ?bool $isCertified = null;

    /**
     * Gets the ID of the certificate.
     *
     * @return int|null The ID of the certificate.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the cursus associated with this certificate.
     *
     * @return Cursus|null The associated cursus.
     */
    public function getCursus(): ?Cursus
    {
        return $this->cursus;
    }

    /**
     * Sets the cursus associated with this certificate.
     *
     * @param Cursus|null $cursus The cursus to associate with this certificate.
     * @return static Returns the current instance for method chaining.
     */
    public function setCursus(?Cursus $cursus): static
    {
        $this->cursus = $cursus;

        return $this;
    }

    /**
     * Gets the lesson associated with this certificate.
     *
     * @return Lesson|null The associated lesson.
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * Sets the lesson associated with this certificate.
     *
     * @param Lesson|null $lesson The lesson to associate with this certificate.
     * @return static Returns the current instance for method chaining.
     */
    public function setLesson(?Lesson $lesson): static
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Gets the user who earned this certificate.
     *
     * @return User|null The user associated with this certificate.
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Sets the user who earned this certificate.
     *
     * @param User|null $user The user to associate with this certificate.
     * @return static Returns the current instance for method chaining.
     */
    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Checks if the certificate is certified.
     *
     * @return bool|null True if certified, otherwise false.
     */
    public function isCertified(): ?bool
    {
        return $this->isCertified;
    }

    /**
     * Sets the certified status of the certificate.
     *
     * @param bool $isCertified The certified status to set.
     * @return static Returns the current instance for method chaining.
     */
    public function setCertified(bool $isCertified): static
    {
        $this->isCertified = $isCertified;

        return $this;
    }
}
