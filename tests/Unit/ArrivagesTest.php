<?php

namespace App\Tests\App\Tests\Unit;

use App\Entity\Arrivages;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArrivagesTest extends KernelTestCase
{
    public function getEntity(): Arrivages
    {
        return (new Arrivages())
            ->setMarque("Produit #1")
            ->setModel("Model #1")
            ->setBoite("Boite #1")
            ->setEnergie("Energie #1")
            ->setPuissance("Puissance #1")
            ->setProperty("Property #1")
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
    }


    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $arrivages = $this->getEntity();

        $errors = $container->get("validator")->validate($arrivages);

        $this->assertCount(0, $errors);
    }

    public function testInvalidMarque()
    {
        self::bootKernel();
        $container = static::getContainer();

        $arrivages = $this->getEntity();

        $errors = $container->get("validator")->validate($arrivages);
        $this->assertCount(1, $errors);
    }
}
