<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }
    public const USER1_REFERENCE = 'user1';
    public const USER2_REFERENCE = 'user2';
    public const USER3_REFERENCE = 'user3';
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
       for ($i = 1; $i<4; ++$i){
         $user = new User();
         $user->setEmail($faker->email());
         $user->setUserName($faker->userName());
         $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));
         $manager->persist($user);
         $this->addReference("user{$i}", $user);
       }

        $manager->flush();
    }
}
