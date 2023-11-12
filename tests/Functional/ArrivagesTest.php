<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\Arrivages;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArrivagesTest extends WebTestCase
{
    public function testIfCreateArrivagesIsSuccessfull(): void
    {
        $client = static::createClient();

        // Recup  urlgenerator
        $urlGenerator = $client->getContainer()->get("router");

        // recup entity manager
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        // Se rendre sur la page de création d'un produit
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate("arrivages.new"));

        // Gérer le formulaire

        $form = $crawler->filter("form[marque=arrivages]")->form([
            "arrivages[marque]" => "Un arrivages"
        ]);

        $client->submit($form);

        // Gérer la redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirects();

        // Gérer l'alert box et la route 
        $this->assertSelectorTextContains("div.alert-success", "Votre Arrivage a été créé avec succès !");

        $this->assertRouteSame("arrivages.index");
    }
}
