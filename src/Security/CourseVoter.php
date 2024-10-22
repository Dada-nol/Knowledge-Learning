<?php

namespace App\Security;

use App\Entity\AccessCourse;
use App\Entity\Course;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CourseVoter extends Voter
{
  private EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  protected function supports(string $attribute, mixed $subject): bool
  {
    return in_array($attribute, ['CAN_ACCESS']) && $subject instanceof Course;
  }

  protected function voteOnAttribute(string $attribute, mixed $course, TokenInterface $token): bool
  {
    $user = $token->getUser();

    if (!$user instanceof User) {
      return false; // Non connecté
    }

    $accessCourse = $this->entityManager->getRepository(AccessCourse::class)->findOneBy([
      'user' => $user,
      'course' => $course,
    ]);

    return $accessCourse ? $accessCourse->isAvailable() : false;
  }
}
