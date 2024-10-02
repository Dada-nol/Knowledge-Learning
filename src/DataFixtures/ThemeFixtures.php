<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{

  public function load(ObjectManager $manager): void
  {
    $theme = new Theme();
    $theme->setName('Musique');

    $theme2 = new Theme();
    $theme2->setName('Informatique');

    $theme3 = new Theme();
    $theme3->setName('Jardinage');

    $theme4 = new Theme();
    $theme4->setName('Cuisine');

    $manager->persist($theme);
    $manager->persist($theme2);
    $manager->persist($theme3);
    $manager->persist($theme4);

    $manager->flush();
  }
}
