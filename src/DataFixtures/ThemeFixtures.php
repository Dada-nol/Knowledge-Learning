<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
  public const THEME_MUSIQUE_REFERENCE = 'theme-musique';
  public const THEME_INFORMATIQUE_REFERENCE = 'theme-informatique';
  public const THEME_JARDINAGE_REFERENCE = 'theme-jardinage';
  public const THEME_CUISINE_REFERENCE = 'theme-cuisine';

  public function load(ObjectManager $manager): void
  {
    $theme = new Theme();
    $theme->setName('Musique');
    $manager->persist($theme);
    $this->addReference(self::THEME_MUSIQUE_REFERENCE, $theme);

    $theme2 = new Theme();
    $theme2->setName('Informatique');
    $manager->persist($theme2);
    $this->addReference(self::THEME_INFORMATIQUE_REFERENCE, $theme2);


    $theme3 = new Theme();
    $theme3->setName('Jardinage');
    $manager->persist($theme3);
    $this->addReference(self::THEME_JARDINAGE_REFERENCE, $theme3);


    $theme4 = new Theme();
    $theme4->setName('Cuisine');
    $manager->persist($theme4);
    $this->addReference(self::THEME_CUISINE_REFERENCE, $theme4);



    $manager->flush();
  }
}
