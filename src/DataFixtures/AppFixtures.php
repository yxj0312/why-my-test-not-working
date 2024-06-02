<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private ProductFactory $productFactory;

    public function __construct(ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }

    public function load(ObjectManager $manager): void
    {
        $products = $this->productFactory->create(10);
        
        foreach ($products as $product) {
            $manager->persist($product);
        }

        $manager->flush();
    }
}
