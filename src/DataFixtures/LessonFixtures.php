<?php

namespace App\DataFixtures;

use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture class for loading sample Lesson entities into the database.
 * Implements DependentFixtureInterface to ensure CursusFixtures are loaded first.
 */
class LessonFixtures extends Fixture implements DependentFixtureInterface
{
  public const LESSON_GUITARE_n°1_REFERENCE = 'lesson-guitare-1';
  public const LESSON_GUITARE_n°2_REFERENCE = 'lesson-guitare-2';
  public const LESSON_PIANO_n°1_REFERENCE = 'lesson-piano-1';
  public const LESSON_PIANO_n°2_REFERENCE = 'lesson-piano-2';
  public const LESSON_DEVELOPPEMENT_n°1_REFERENCE = 'lesson-dev_web-1';
  public const LESSON_DEVELOPPEMENT_n°2_REFERENCE = 'lesson-dev_web-2';
  public const LESSON_JARDINAGE_n°1_REFERENCE = 'lesson-jardinage-1';
  public const LESSON_JARDINAGE_n°2_REFERENCE = 'lesson-jardinage-2';
  public const LESSON_CUISINE_n°1_REFERENCE = 'lesson-cuisine-1';
  public const LESSON_CUISINE_n°2_REFERENCE = 'lesson-cuisine-2';
  public const LESSON_DRESSAGE_n°1_REFERENCE = 'lesson-dressage_culinaire-1';
  public const LESSON_DRESSAGE_n°2_REFERENCE = 'lesson-dressage_culinaire-2';

  /**
   * Loads a set of predefined Lesson entities into the database.
   * Each lesson is associated with a specific cursus, which is loaded by CursusFixtures.
   * 
   * @param ObjectManager $manager The Doctrine object manager used for persisting entities.
   */
  public function load(ObjectManager $manager)
  {
    $lesson = new Lesson();
    $lesson->setName('Leçon n°1 : Découverte de l\'instrument');
    $lesson->setPrice(26);
    $lesson->setCursus($this->getReference(CursusFixtures::CURSUS_GUITARE_REFERENCE));
    $manager->persist($lesson);
    $this->addReference(self::LESSON_GUITARE_n°1_REFERENCE, $lesson);

    $lesson2 = new Lesson();
    $lesson2->setName('Leçon n°2 : Les accords et les gammes');
    $lesson2->setPrice(26);
    $lesson2->setCursus($this->getReference(CursusFixtures::CURSUS_GUITARE_REFERENCE));
    $manager->persist($lesson2);
    $this->addReference(self::LESSON_GUITARE_n°2_REFERENCE, $lesson2);

    $lesson3 = new Lesson();
    $lesson3->setName('Leçon n°1 : Découverte de l\'instrument');
    $lesson3->setPrice(26);
    $lesson3->setCursus($this->getReference(CursusFixtures::CURSUS_PIANO_REFERENCE));
    $manager->persist($lesson3);
    $this->addReference(self::LESSON_PIANO_n°1_REFERENCE, $lesson3);

    $lesson4 = new Lesson();
    $lesson4->setName('Leçon n°2 : Les accords et les gammes');
    $lesson4->setPrice(26);
    $lesson4->setCursus($this->getReference(CursusFixtures::CURSUS_PIANO_REFERENCE));
    $manager->persist($lesson4);
    $this->addReference(self::LESSON_PIANO_n°2_REFERENCE, $lesson4);

    $lesson5 = new Lesson();
    $lesson5->setName('Leçon n°1 : Les langages Html et CSS');
    $lesson5->setPrice(32);
    $lesson5->setCursus($this->getReference(CursusFixtures::CURSUS_DEVELOPPEMENT_REFERENCE));
    $manager->persist($lesson5);
    $this->addReference(self::LESSON_DEVELOPPEMENT_n°1_REFERENCE, $lesson5);

    $lesson6 = new Lesson();
    $lesson6->setName('Leçon n°2 : Dynamiser votre site avec Javascript');
    $lesson6->setPrice(32);
    $lesson6->setCursus($this->getReference(CursusFixtures::CURSUS_DEVELOPPEMENT_REFERENCE));
    $manager->persist($lesson6);
    $this->addReference(self::LESSON_DEVELOPPEMENT_n°2_REFERENCE, $lesson6);

    $lesson7 = new Lesson();
    $lesson7->setName('Leçon n°1 : Les outils du jardinier');
    $lesson7->setPrice(16);
    $lesson7->setCursus($this->getReference(CursusFixtures::CURSUS_JARDINAGE_REFERENCE));
    $manager->persist($lesson7);
    $this->addReference(self::LESSON_JARDINAGE_n°1_REFERENCE, $lesson7);

    $lesson8 = new Lesson();
    $lesson8->setName('Leçon n°2 : Jardiner avec la lune');
    $lesson8->setPrice(16);
    $lesson8->setCursus($this->getReference(CursusFixtures::CURSUS_JARDINAGE_REFERENCE));
    $manager->persist($lesson8);
    $this->addReference(self::LESSON_JARDINAGE_n°2_REFERENCE, $lesson8);

    $lesson9 = new Lesson();
    $lesson9->setName('Leçon n°1 : Les modes de cuisson');
    $lesson9->setPrice(23);
    $lesson9->setCursus($this->getReference(CursusFixtures::CURSUS_CUISINE_REFERENCE));
    $manager->persist($lesson9);
    $this->addReference(self::LESSON_CUISINE_n°1_REFERENCE, $lesson9);

    $lesson10 = new Lesson();
    $lesson10->setName('Leçon n°2 : Les saveurs');
    $lesson10->setPrice(23);
    $lesson10->setCursus($this->getReference(CursusFixtures::CURSUS_CUISINE_REFERENCE));
    $manager->persist($lesson10);
    $this->addReference(self::LESSON_CUISINE_n°2_REFERENCE, $lesson10);

    $lesson11 = new Lesson();
    $lesson11->setName('Leçon n°1 : Mettre en œuvre le style dans l\'assiette');
    $lesson11->setPrice(26);
    $lesson11->setCursus($this->getReference(CursusFixtures::CURSUS_DRESSAGE_REFERENCE));
    $manager->persist($lesson11);
    $this->addReference(self::LESSON_DRESSAGE_n°1_REFERENCE, $lesson11);

    $lesson12 = new Lesson();
    $lesson12->setName('Leçon n°2 : Harmoniser un repas à quatre plats');
    $lesson12->setPrice(26);
    $lesson12->setCursus($this->getReference(CursusFixtures::CURSUS_DRESSAGE_REFERENCE));
    $manager->persist($lesson12);
    $this->addReference(self::LESSON_DRESSAGE_n°2_REFERENCE, $lesson12);

    $manager->flush();
  }

  /**
   * Returns an array of fixture dependencies.
   * 
   * @return array The array of dependent fixture classes.
   */
  public function getDependencies(): array
  {
    return [
      CursusFixtures::class
    ];
  }
}
