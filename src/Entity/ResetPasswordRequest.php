<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

/**
 * Class ResetPasswordRequest
 *
 * Represents a request to reset a user's password, including information about the user and the token.
 *
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
#[HasLifecycleCallbacks]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;
    use Timestampable;

    /**
     * @var int|null The unique identifier for this reset password request.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var User|null The user associated with this reset password request.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * ResetPasswordRequest constructor.
     *
     * @param User $user The user requesting a password reset.
     * @param \DateTimeInterface $expiresAt The expiration date of the reset request.
     * @param string $selector The selector for the password reset token.
     * @param string $hashedToken The hashed token for the password reset request.
     */
    public function __construct(User $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    /**
     * Gets the ID of the reset password request.
     *
     * @return int|null The ID of the request.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the user associated with this reset password request.
     *
     * @return User The associated user.
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
