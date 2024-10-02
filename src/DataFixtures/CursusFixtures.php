<?php

namespace App\DataFixtures;

use App\Entity\Cursus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CursusFixtures extends Fixture implements DependentFixtureInterface
{

  public function load(ObjectManager $manager): void
  {
    $cursus = new Cursus();
    $cursus->setName('Cursus d\'initiation à la guitare');
    $cursus->setPrice(50);
    $cursus->setTheme($this->getReference(ThemeFixtures::THEME_MUSIQUE_REFERENCE));
    $manager->persist($cursus);

    $cursus2 = new Cursus();
    $cursus2->setName('Cursus d\'initiation au piano');
    $cursus2->setPrice(50);
    $cursus2->setTheme($this->getReference(ThemeFixtures::THEME_MUSIQUE_REFERENCE));
    $manager->persist($cursus2);

    $cursus3 = new Cursus();
    $cursus3->setName('Cursus d\'initiation au développement web');
    $cursus3->setPrice(60);
    $cursus3->setTheme($this->getReference(ThemeFixtures::THEME_INFORMATIQUE_REFERENCE));
    $manager->persist($cursus3);

    $cursus4 = new Cursus();
    $cursus4->setName('Cursus d\'initiation au jardinage');
    $cursus4->setPrice(30);
    $cursus4->setTheme($this->getReference(ThemeFixtures::THEME_JARDINAGE_REFERENCE));
    $manager->persist($cursus4);

    $cursus5 = new Cursus();
    $cursus5->setName('Cursus d\'initiation à la cuisine');
    $cursus5->setPrice(44);
    $cursus5->setTheme($this->getReference(ThemeFixtures::THEME_CUISINE_REFERENCE));
    $manager->persist($cursus5);

    $cursus6 = new Cursus();
    $cursus6->setName('Cursus d\'initiation à l\'art du dressage culinaire');
    $cursus6->setPrice(48);
    $cursus6->setTheme($this->getReference(ThemeFixtures::THEME_CUISINE_REFERENCE));
    $manager->persist($cursus6);


    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      ThemeFixtures::class
    ];
  }
}
