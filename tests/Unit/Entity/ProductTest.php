<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class ProductTest extends TestCase
{
    public function testCanGetAndSetData(): void
    {
      $product = new Product();
        $product->setName('Example Product');
        $product->setPrice(19.99);

        self::assertSame('Example Product', $product->getName());
    }

    public function testAnotherDate(): void
    {
      
    }
}
