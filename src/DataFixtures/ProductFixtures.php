<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setName($faker->word())
                ->setDescription($faker->sentence())
                ->setImage($faker->imageUrl(640, 480, 'products', true))
                ->setPrice($faker->randomFloat(2, 10, 100))
                ->setStock($faker->numberBetween(1, 100))
                ->setActive($faker->boolean())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $slug = $this->slugger->slug($product->getName())->lower()->toString();
            $product->setSlug($slug);

            // associer une catégorie aléatoire
            $categoryIndex = rand(0, 9);
            $category = $this->getReference('category_' . $categoryIndex, Category::class);
            $product->setCategory($category);
            
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
   
}
