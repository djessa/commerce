<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        
        for ($i = 0; $i < 30; $i++) {
            $product = new Product();
            $product->setName($faker->productName)
                    ->setPrice($faker->price(20, 200))
                    ->setStock(10)
                    ->setImage($faker->imageUrl(400, 400));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
