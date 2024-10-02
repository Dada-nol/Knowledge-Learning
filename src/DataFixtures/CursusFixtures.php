<?php

namespace App\DataFixtures;

use App\Entity\Cursus;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CursusFixtures extends Fixture
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


    $cursus = new Cursus();
    $cursus->setName('Cursus d\'initiation à la guitare');
    $cursus->setPrice(50);
    $cursus->setTheme($theme);

    $cursus2 = new Cursus();
    $cursus2->setName('Cursus d\'initiation au piano');
    $cursus2->setPrice(50);
    $cursus2->setTheme($theme);

    $cursus3 = new Cursus();
    $cursus3->setName('Cursus d\'initiation au développement web');
    $cursus3->setPrice(60);
    $cursus3->setTheme($theme2);

    $cursus4 = new Cursus();
    $cursus4->setName('Cursus d\'initiation au jardinage');
    $cursus4->setPrice(30);
    $cursus4->setTheme($theme3);

    $cursus5 = new Cursus();
    $cursus5->setName('Cursus d\'initiation à la cuisine');
    $cursus5->setPrice(44);
    $cursus5->setTheme($theme4);

    $cursus6 = new Cursus();
    $cursus6->setName('Cursus d\'initiation à l\'art du dressage culinaire');
    $cursus6->setPrice(48);
    $cursus6->setTheme($theme4);

    $manager->persist($cursus);
    $manager->persist($cursus2);
    $manager->persist($cursus3);
    $manager->persist($cursus4);
    $manager->persist($cursus5);
    $manager->persist($cursus6);


    $manager->flush();
  }
}
