<?php

namespace App\DataFixtures;

use App\Entity\Top;
use App\Entity\User;
use App\Entity\Category;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        $titles=[];
        for($i=1; $i<12; ++$i){
            $userRef = 'user'.($i % 3) + 1;
            /** @var User $refUser */
            $refUser = $this->getReference($userRef);
            $category = new Category();

            do{
                $title=$this->faker->word();
            }while(in_array($title, $titles, true));
            $titles[]=$title;

            $category->setTitle($title);
            $category->setSlug($this->slugger->slug($title)->lower());
            $category->setAuthor($refUser);
            $manager->persist($category);
            $this->addReference("category{$i}", $category);
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
