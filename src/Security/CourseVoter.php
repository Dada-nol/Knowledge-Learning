<?php

namespace App\Security;

use App\Entity\AccessCourse;
use App\Entity\Course;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * CourseVoter is responsible for checking if a user can access a specific course.
 * 
 * This voter checks if the user has access rights to a course by looking for
 * an AccessCourse entity that links the user to the course. If such an entity
 * exists, the voter then checks if the course is available to the user.
 */
class CourseVoter extends Voter
{
  private EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * Determines if the voter supports the given attribute and subject.
   *
   * @param string $attribute The attribute to vote on (e.g., 'CAN_ACCESS')
   * @param mixed $subject The subject of the vote (should be a Course object)
   * @return bool True if this voter supports the attribute and subject
   */
  protected function supports(string $attribute, mixed $subject): bool
  {
    return in_array($attribute, ['CAN_ACCESS']) && $subject instanceof Course;
  }

  /**
   * Perform the authorization logic for the supported attribute and subject.
   *
   * @param string $attribute The attribute to vote on
   * @param mixed $course The course that the user is trying to access
   * @param TokenInterface $token The security token containing the current user
   * @return bool True if the user is allowed to access the course, false otherwise
   */
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
