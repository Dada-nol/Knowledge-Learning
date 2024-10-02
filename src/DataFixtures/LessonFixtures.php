<?php

namespace App\DataFixtures;

use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LessonFixtures extends Fixture implements DependentFixtureInterface
{

  public function load(ObjectManager $manager)
  {

    $lesson = new Lesson();
    $lesson->setName('Leçon n°1 : Découverte de l\'instrument');
    $lesson->setPrice(26);
    $lesson->setCursus($this->getReference(CursusFixtures::CURSUS_GUITARE_REFERENCE));
    $manager->persist($lesson);

    $lesson2 = new Lesson();
    $lesson2->setName('Leçon n°2 : Les accords et les gammes');
    $lesson2->setPrice(26);
    $lesson2->setCursus($this->getReference(CursusFixtures::CURSUS_GUITARE_REFERENCE));
    $manager->persist($lesson2);

    $lesson3 = new Lesson();
    $lesson3->setName('Leçon n°1 : Découverte de l\'instrument');
    $lesson3->setPrice(26);
    $lesson3->setCursus($this->getReference(CursusFixtures::CURSUS_PIANO_REFERENCE));
    $manager->persist($lesson3);

    $lesson4 = new Lesson();
    $lesson4->setName('Leçon n°2 : Les accords et les gammes');
    $lesson4->setPrice(26);
    $lesson4->setCursus($this->getReference(CursusFixtures::CURSUS_PIANO_REFERENCE));
    $manager->persist($lesson4);

    $lesson5 = new Lesson();
    $lesson5->setName('Leçon n°1 : Les langages Html et CSS');
    $lesson5->setPrice(32);
    $lesson5->setCursus($this->getReference(CursusFixtures::CURSUS_DEVELOPPEMENT_REFERENCE));
    $manager->persist($lesson5);

    $lesson6 = new Lesson();
    $lesson6->setName('Leçon n°2 : Dynamiser votre site avec Javascript');
    $lesson6->setPrice(32);
    $lesson6->setCursus($this->getReference(CursusFixtures::CURSUS_DEVELOPPEMENT_REFERENCE));
    $manager->persist($lesson6);

    $lesson7 = new Lesson();
    $lesson7->setName('Leçon n°1 : Les outils du jardinier');
    $lesson7->setPrice(16);
    $lesson7->setCursus($this->getReference(CursusFixtures::CURSUS_JARDINAGE_REFERENCE));
    $manager->persist($lesson7);

    $lesson8 = new Lesson();
    $lesson8->setName('Leçon n°2 : Jardiner avec la lune');
    $lesson8->setPrice(16);
    $lesson8->setCursus($this->getReference(CursusFixtures::CURSUS_JARDINAGE_REFERENCE));
    $manager->persist($lesson8);

    $lesson9 = new Lesson();
    $lesson9->setName('Leçon n°1 : Les modes de cuisson');
    $lesson9->setPrice(23);
    $lesson9->setCursus($this->getReference(CursusFixtures::CURSUS_CUISINE_REFERENCE));
    $manager->persist($lesson9);

    $lesson10 = new Lesson();
    $lesson10->setName('Leçon n°2 : Les saveurs');
    $lesson10->setPrice(23);
    $lesson10->setCursus($this->getReference(CursusFixtures::CURSUS_CUISINE_REFERENCE));
    $manager->persist($lesson10);

    $lesson = new Lesson();
    $lesson->setName('Leçon n°1 : Mettre en œuvre le style dans l\'assiette');
    $lesson->setPrice(26);
    $lesson->setCursus($this->getReference(CursusFixtures::CURSUS_DRESSAGE_REFERENCE));
    $manager->persist($lesson);

    $lesson = new Lesson();
    $lesson->setName('Leçon n°2 : Harmoniser un repas à quatre plats');
    $lesson->setPrice(26);
    $lesson->setCursus($this->getReference(CursusFixtures::CURSUS_DRESSAGE_REFERENCE));
    $manager->persist($lesson);

    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      CursusFixtures::class
    ];
  }
}
