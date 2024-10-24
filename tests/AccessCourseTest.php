<?php

namespace App\Tests;

use App\Entity\AccessCourse;
use App\Entity\User;
use App\Entity\Course;
use App\Security\CourseVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AccessCourseTest extends KernelTestCase
{

  private $entityManager;

  protected function setUp(): void
  {
    self::bootKernel();
    $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

    $this->entityManager->getConnection()->beginTransaction();
  }

  protected function tearDown(): void
  {
    $this->entityManager->getConnection()->rollBack();

    parent::tearDown();

    $this->entityManager->close();
    $this->entityManager = null;
  }


  public function testAccessCourseUserRelation()
  {
    $user = new User();
    $user->setEmail('test@gmail.com');
    $user->setPassword('password');
    $course = new Course();
    $course->setTitle('test');
    $course->setContent('un content test');
    $accessCourse = new AccessCourse();

    $accessCourse->setUser($user);
    $accessCourse->setCourse($course);

    $this->assertSame($user, $accessCourse->getUser());
    $this->assertSame($course, $accessCourse->getCourse());

    $available = true;

    $accessCourse->setAvailable($available);
    $this->assertTrue($accessCourse->isAvailable());

    $this->entityManager->persist($user);
    $this->entityManager->persist($course);
    $this->entityManager->persist($accessCourse);
    $this->entityManager->flush();

    $token = new UsernamePasswordToken($user, 'credentials', $user->getRoles());

    $voter = new CourseVoter($this->entityManager);
    $result = $voter->vote($token, $course, ['CAN_ACCESS']);

    $this->assertEquals(CourseVoter::ACCESS_GRANTED, $result);

    $accessCourse->setAvailable(false);
    $this->assertFalse($accessCourse->isAvailable());
  }
}
