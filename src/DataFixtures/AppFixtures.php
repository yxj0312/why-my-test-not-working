<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // public function __construct(
    // )
    // {
        
    // }
    public function load(ObjectManager $manager): void
    {
        $this->loadProducts($manager);
    }

    private function loadProducts(ObjectManager $manager): void
    {
        // Use a factory to create 10 products with randomized data
        $products = ProductFactory::create(10);

        foreach ($products as $product) {
            $manager->persist($product);
        }
        $manager->flush();
    }
}
