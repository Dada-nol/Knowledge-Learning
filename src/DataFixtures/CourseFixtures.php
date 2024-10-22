<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{

  public function load(ObjectManager $manager)
  {

    $course = new Course();
    $course->setTitle('Découvrons la guitare');
    $course->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course->setLesson($this->getReference(LessonFixtures::LESSON_GUITARE_n°1_REFERENCE));
    $manager->persist($course);

    $course2 = new Course();
    $course2->setTitle('Découverte de nouvelles mélodies');
    $course2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course2->setLesson($this->getReference(LessonFixtures::LESSON_GUITARE_n°2_REFERENCE));
    $manager->persist($course2);

    $course3 = new Course();
    $course3->setTitle('Découverte du piano');
    $course3->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course3->setLesson($this->getReference(LessonFixtures::LESSON_PIANO_n°1_REFERENCE));
    $manager->persist($course3);

    $course4 = new Course();
    $course4->setTitle('Explorons de nouvelles gammes');
    $course4->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course4->setLesson($this->getReference(LessonFixtures::LESSON_PIANO_n°2_REFERENCE));
    $manager->persist($course4);


    $course5 = new Course();
    $course5->setTitle('Les langages Html et CSS');
    $course5->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course5->setLesson($this->getReference(LessonFixtures::LESSON_DEVELOPPEMENT_n°1_REFERENCE));
    $manager->persist($course5);


    $course6 = new Course();
    $course6->setTitle('Dynamiser votre site avec Javascript');
    $course6->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course6->setLesson($this->getReference(LessonFixtures::LESSON_DEVELOPPEMENT_n°2_REFERENCE));
    $manager->persist($course6);


    $course7 = new Course();
    $course7->setTitle('Les outils du jardinier');
    $course7->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course7->setLesson($this->getReference(LessonFixtures::LESSON_JARDINAGE_n°1_REFERENCE));
    $manager->persist($course7);


    $course8 = new Course();
    $course8->setTitle('Jardiner avec la lune');
    $course8->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course8->setLesson($this->getReference(LessonFixtures::LESSON_JARDINAGE_n°2_REFERENCE));
    $manager->persist($course8);


    $course9 = new Course();
    $course9->setTitle('Les modes de cuisson');
    $course9->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course9->setLesson($this->getReference(LessonFixtures::LESSON_CUISINE_n°1_REFERENCE));
    $manager->persist($course9);


    $course10 = new Course();
    $course10->setTitle('Les saveurs');
    $course10->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course10->setLesson($this->getReference(LessonFixtures::LESSON_CUISINE_n°2_REFERENCE));
    $manager->persist($course10);


    $course11 = new Course();
    $course11->setTitle('Mettre en œuvre le style dans l\'assiette');
    $course11->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course11->setLesson($this->getReference(LessonFixtures::LESSON_DRESSAGE_n°1_REFERENCE));
    $manager->persist($course11);


    $course12 = new Course();
    $course12->setTitle('Harmoniser un repas à quatre plats');
    $course12->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    $course12->setLesson($this->getReference(LessonFixtures::LESSON_DRESSAGE_n°2_REFERENCE));
    $manager->persist($course12);


    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      LessonFixtures::class
    ];
  }
}
