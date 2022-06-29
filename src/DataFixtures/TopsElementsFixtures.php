<?php

namespace App\DataFixtures;
use App\Entity\Top;
use App\entity\TopElement;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TopsElementsFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<61; ++$i){
            /** @var Top  $top */
            $top = $this->getReference("top".($i%12+1));
            /** @var User  $user */
            $user = $this->getReference("user".($i%3+1));
            $topElement = new TopElement();
            $topElement->setTop($top);
            $topElement->setAuthor($user);
            $topElement->setRank($this->faker->randomDigit());
            $topElement->setContent($this->faker->words(1, true));
            $manager->persist($topElement);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [
            UserFixtures::class,
            TopsFixtures::class,
        ];
    }
}
