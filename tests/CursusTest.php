<?php

namespace App\Tests;

use App\Entity\Cursus;
use App\Entity\Lesson;
use App\Entity\Theme;
use PHPUnit\Framework\TestCase;

class CursusTest extends TestCase
{
  public function testCursusRelation()
  {
    $theme = new Theme();
    $theme->setName('Test Theme');

    $this->assertSame('Test Theme', $theme->getName());

    $cursus = new Cursus();
    $cursus->setName('Test Cursus');
    $cursus->setPrice(50);
    $cursus->setTheme($theme);

    $this->assertSame('Test Cursus', $cursus->getName());
    $this->assertSame($theme, $cursus->getTheme());
    $this->assertSame(50, $cursus->getPrice());

    $lesson = new Lesson();
    $lesson->setName('Test Lesson');
    $lesson->setPrice(40);
    $lesson->setCursus($cursus);

    $this->assertSame('Test Lesson', $lesson->getName());
    $this->assertSame($cursus, $lesson->getCursus());
    $this->assertSame(40, $lesson->getPrice());
  }
}
