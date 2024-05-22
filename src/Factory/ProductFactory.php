<?php

namespace App\Factory;

use App\Entity\Product;
use Faker\Factory;

class ProductFactory
{
    public static function create(int $count = 1): array
    {
        $faker = Factory::create();
        $products = [];

        for ($i = 0; $i < $count; $i++) {
            $product = new Product();
            $product->setName($faker->word);
            $product->setDescription($faker->sentence);
            $product->setPrice($faker->randomFloat(2, 10, 100));
            $product->setQuantity($faker->numberBetween(1, 100));
            $product->setImage($faker->imageUrl());
            $product->setIsFeatured($faker->boolean);
            $product->setIsActive($faker->boolean);
            $product->setMetaTitle($faker->sentence);
            $product->setMetaDescription($faker->sentence);
            $product->setSlug($faker->slug);
            $product->setFeatureImage($faker->imageUrl());

            // Add the product to the array
            $products[] = $product;
        }

        return $products;
    }
}