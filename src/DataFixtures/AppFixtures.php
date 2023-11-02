<?php

namespace App\DataFixtures;

use App\Entity\Arrivages;
use App\Entity\User;
use App\Entity\Review;
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
                ->setPuissance($puissanceOptions[array_rand($puissanceOptions)])
                ->setDescription($this->faker->text(300))
                ->setIsPublic(mt_rand(0, 1) == 1 ? true : false);

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
                ->setIsAvaillable(mt_rand(0, 1) ? true : false)
                ->setIsPublic(mt_rand(0, 1) == 1 ? true : false);

            $manager->persist($arrivages);
        }

        // Users 
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->SetPlainPassword('password');


            $manager->persist($user);
        }

        // Review
        for ($r = 0; $r < 10; $r++) {
            $review = new Review();
            $review->setNom($this->faker->name())
                ->setPrenom($this->faker->firstName())
                ->setMessage($this->faker->text(255))
                ->setRoles(['ROLE_USER']);


            $manager->persist($review);
        }

        $manager->flush();
    }
}
