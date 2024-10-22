<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('jhon_doe@gmail.com');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_CLIENT']);
        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);
        $user->setVerified(true);

        $user2 = new User();
        $user2->setEmail('test@gmail.com');
        $user2->setRoles(['ROLE_USER']);
        $password2 = $this->hasher->hashPassword($user2, 'test');
        $user2->setPassword($password2);
        $user2->setVerified(false);



        $manager->persist($user);
        $manager->persist($user2);

        $manager->flush();
    }
}
