<?php

namespace App\Tests;

use App\Entity\Certificate;
use App\Entity\Cursus;
use App\Entity\Lesson;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CertificateTest extends TestCase
{
  public function testCursusRelation()
  {
    $user = new User();
    $user->setEmail('nini@gmail.com');
    $user->setPassword('password');

    $cursus = new Cursus();
    $cursus->setName('Test Cursus');
    $cursus->setPrice(50);

    $lesson = new Lesson();
    $lesson->setName('Test Lesson');
    $lesson->setPrice(40);
    $lesson->setCursus($cursus);

    $certificate = new Certificate();
    $certificate->setCertified(true);
    $certificate->setUser($user);
    $certificate->setLesson($lesson);

    $this->assertTrue($certificate->isCertified());
    $this->assertSame($user, $certificate->getUser());
    $this->assertSame($lesson, $certificate->getLesson());

    $certificate->setCertified(false);

    $this->assertFalse($certificate->isCertified());

    $certificate2 = new Certificate();
    $certificate2->setCertified(true);
    $certificate2->setUser($user);
    $certificate2->setCursus($cursus);

    $this->assertTrue($certificate2->isCertified());
    $this->assertSame($user, $certificate2->getUser());
    $this->assertSame($cursus, $certificate2->getCursus());
  }
}
