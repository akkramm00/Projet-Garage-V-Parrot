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

    public function testIfListArrivagesIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate("arrivages"));

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame("arrivages.index");
    }

    public function testIfUpdateArrivagesIsSuccefull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);
        $arrivages = $entityManager->getRepository(Arrivages::class)->findOneBy([
            "user" => $user
        ]);

        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("arrivages.edit", ["id" => $arrivages->getId()]),
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form[marque=arrivages]")->form([
            "arrivages[marque]" => "Un arrivage 2"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains("div.alert-success", "Votre Arrivage a été modifié avec succès !");

        $this->assertRouteSame("arrivages.index");
    }

    public function testIfDeleteArrivagesIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);
        $arrivages = $entityManager->getRepository(Arrivages::class)->findOneBy([
            "user" => $user
        ]);

        $client->loginUser($user);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("arrivages.delete", ["id" => $arrivages->getId()]),
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains("div.alert-success", "L\'arrivage a été supprimé avec succès !");

        $this->assertRouteSame("arrivages.index");
    }
}
