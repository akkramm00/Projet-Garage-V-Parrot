<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Entity\Arrivages;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Contact;
use Faker\Factory;
use Faker\Generator;
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
                ->setPrix(mt_rand('15000', '50000'))
                ->setYear(mt_rand('2018', '2023'))
                ->setKelometre(mt_rand('10000', '50000'))
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
        $users = [];

        $admin = new User();
        $admin->setFullName('Administrateur de garageVP')
            ->setPseudo('null')
            ->setEmail('admin@garagevp.fr')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->SetPlainPassword('password');

        $users[] = $admin;
        $manager->persist($admin);


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
                ->setRoles(['ROLE_USER'])
                ->setIsPublic(mt_rand(0, 1) == 1 ? true : false);

            $manager->persist($review);
        }

        // Contact
        for ($c = 0; $c < 5; $c++) {
            $contact = new Contact();
            $contact->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setSubject('Demande n° . ($c + 1')
                ->setMessage($this->faker->text());

            $manager->persist($contact);
        }

        $manager->flush();
    }
}
