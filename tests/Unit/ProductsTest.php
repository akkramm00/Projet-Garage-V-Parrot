<?php

namespace App\Tests\App\Tests\Unit;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductsTest extends KernelTestCase
{
    public function getEntity(): Products
    {
        return (new Products())
            ->setMarque("Produit #1")
            ->setModel("Model #1")
            ->setBoite("Boite #1")
            ->setEnergie("Energie #1")
            ->setPuissance("Puissance #1")
            ->setDescription("Description #1")
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
    }


    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $products = $this->getEntity();

        $errors = $container->get("validator")->validate($products);

        $this->assertCount(0, $errors);
    }

    public function testInvalidMarque()
    {
        self::bootKernel();
        $container = static::getContainer();

        $products = $this->getEntity();

        $errors = $container->get("validator")->validate($products);
        $this->assertCount(1, $errors);
    }
}
