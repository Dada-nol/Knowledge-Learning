<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * Represents a user in the system, implementing security-related interfaces for authentication.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    use Timestampable;
    /**
     * @var int|null The unique identifier for the user.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null The email of the user.
     */
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles.
     */
    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password.
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var bool Indicates whether the user is verified.
     */
    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, AccessCourse> A collection of access courses associated with the user.
     */
    #[ORM\OneToMany(targetEntity: AccessCourse::class, mappedBy: 'user')]
    private Collection $course;

    /**
     * @var Collection<int, Certificate> A collection of certificates associated with the user.
     */
    #[ORM\OneToMany(targetEntity: Certificate::class, mappedBy: 'user')]
    private Collection $certificates;

    public function __construct()
    {
        $this->course = new ArrayCollection();
        $this->certificates = new ArrayCollection();
    }

    /**
     * Gets the ID of the user.
     *
     * @return int|null The ID of the user.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the email of the user.
     *
     * @return string|null The email of the user.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets the email of the user.
     *
     * @param string $email The email to set for the user.
     * @return static The current instance.
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Gets the roles assigned to the user.
     *
     * @return list<string> The roles assigned to the user.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Sets the roles for the user.
     *
     * @param list<string> $roles The roles to assign to the user.
     * @return static The current instance.
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Gets the hashed password of the user.
     *
     * @return string|null The hashed password.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Sets the password for the user.
     *
     * @param string $password The hashed password to set.
     * @return static The current instance.
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Erases sensitive data from the user.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Checks if the user is verified.
     *
     * @return bool True if the user is verified, false otherwise.
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * Sets the verification status of the user.
     *
     * @param bool $isVerified The verification status to set.
     * @return static The current instance.
     */
    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Gets the collection of access courses associated with the user.
     *
     * @return Collection<int, AccessCourse> The collection of access courses.
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    /**
     * Adds an access course to the user.
     *
     * @param AccessCourse $course The access course to add.
     * @return static The current instance.
     */
    public function addCourse(AccessCourse $course): static
    {
        if (!$this->course->contains($course)) {
            $this->course->add($course);
            $course->setUser($this);
        }

        return $this;
    }

    /**
     * Removes an access course from the user.
     *
     * @param AccessCourse $course The access course to remove.
     * @return static The current instance.
     */
    public function removeCourse(AccessCourse $course): static
    {
        if ($this->course->removeElement($course)) {
            if ($course->getUser() === $this) {
                $course->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Converts the user to a string representation.
     *
     * @return string The email of the user.
     */
    public function __toString(): string
    {
        return $this->getEmail();
    }

    /**
     * Gets the collection of certificates associated with the user.
     *
     * @return Collection<int, Certificate> The collection of certificates.
     */
    public function getCertificates(): Collection
    {
        return $this->certificates;
    }

    /**
     * Adds a certificate to the user.
     *
     * @param Certificate $certificate The certificate to add.
     * @return static The current instance.
     */
    public function addCertificate(Certificate $certificate): static
    {
        if (!$this->certificates->contains($certificate)) {
            $this->certificates->add($certificate);
            $certificate->setUser($this);
        }

        return $this;
    }

    /**
     * Removes a certificate from the user.
     *
     * @param Certificate $certificate The certificate to remove.
     * @return static The current instance.
     */
    public function removeCertificate(Certificate $certificate): static
    {
        if ($this->certificates->removeElement($certificate)) {
            // set the owning side to null (unless already changed)
            if ($certificate->getUser() === $this) {
                $certificate->setUser(null);
            }
        }

        return $this;
    }
}
