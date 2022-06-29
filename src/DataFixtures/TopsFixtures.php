<?php

namespace App\DataFixtures;

use App\Entity\Top;
use App\Entity\User;
use App\Enums\TopColors;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TopsFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<13; ++$i){
            $userRef = 'user'.($i % 3) + 1;
            /** @var User $refUser */
            $refUser = $this->getReference($userRef);
            $top = new Top();
            $top->setTitle($this->faker->sentence());
            $top->setIcon($this->faker->words(1, true));
            $top->setColor(TopColors::COLOR_BLUE->value);
            $top->setCollaborative(false);
            $top->setAuthor($refUser);
            $manager->persist($top);
            $this->addReference("top{$i}", $top);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [
            UserFixtures::class,
        ];
    }
}
