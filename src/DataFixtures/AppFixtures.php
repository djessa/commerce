<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        
        $admin = new Admin();
        $admin->setPassword($this->userPasswordEncoder->encodePassword($admin, "password"));
        $admin->setEmail("admin@email.com");
        $manager->persist($admin);

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
