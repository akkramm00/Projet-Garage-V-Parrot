<?php

namespace App\DataFixtures;

use App\Entity\Arrivages;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @var generator
     */
    private Generator $faker;

    public function __construct()

    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        // Products
        $puissanceOptions = [100, 150, 200, 250];
        $marqueOptions = ['Mercedes', 'Audi', 'wolkzvagen', 'BMW'];
        $energieOptions = ['Diesel', 'Essence', 'Electric'];

        for ($p = 1; $p <= 50; $p++) {
            $products = new Products();
            $products->setMarque($marqueOptions[array_rand($marqueOptions)])
                ->setModel($this->faker->word())
                ->setPrix(mt_rand('15000', '40000'))
                ->setBoite((rand(0, 1) ? 'mecanique' : 'Automatique'))
                ->setEnergie($energieOptions[array_rand($energieOptions)])
                ->setPuissance($puissanceOptions[array_rand($puissanceOptions)]);

            $manager->persist($products);
        }

        //Arrivages
        $puissanceOptions = [100, 150, 200, 250];
        $marqueOptions = ['Mercedes', 'Audi', 'wolkzvagen', 'BMW'];
        $energieOptions = ['Diesel', 'Essence', 'Electric'];

        for ($j = 0; $j < 20; $j++) {

            $arrivages = new Arrivages();
            $arrivages->setMarque($marqueOptions[array_rand($marqueOptions)])
                ->setModel($this->faker->word())
                ->setProperty($this->faker->text(300))
                ->setBoite((rand(0, 1) ? 'mecanique' : 'Automatique'))
                ->setEnergie($energieOptions[array_rand($energieOptions)])
                ->setPuissance($puissanceOptions[array_rand($puissanceOptions)])
                ->setIsAvaillable(mt_rand(0, 1) == 1 ? true : false);

            $manager->persist($arrivages);
        }

        $manager->flush();
    }
}
