<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private SluggerInterface $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setActive($faker->boolean());

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category->getName())));
            $category->setSlug($slug);


            $manager->persist($category);
            $this->addReference('category_' . $i, $category);
        }

        $manager->flush();
    }
}
