<?php

namespace App\Test\Functional;

use App\Entity\User;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsTest extends WebTestCase
{
    public function testIfCreateProductsIsSuccessfull(): void
    {
        $client = static::createClient();

        // Recup  urlgenerator
        $urlGenerator = $client->getContainer()->get("router");

        // recup entity manager
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        // Se rendre sur la page de création d'un produit
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate("products.new"));

        // Gérer le formulaire

        $form = $crawler->filter("form[marque=products]")->form([
            "products[marque]" => "Un produit",
            "products[prix]" => floatval(33)
        ]);

        $client->submit($form);

        // Gérer la redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirects();

        // Gérer l'alert box et la route 
        $this->assertSelectorTextContains("div.alert-success", "Votre produit a été créé avec succès !");

        $this->assertRouteSame("products");
    }

    public function testIfListProductsIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate("products"));

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame("produts");
    }

    public function testIfUpdateProductsIsSuccefull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);
        $products = $entityManager->getRepository(Products::class)->findOneBy([
            "user" => $user
        ]);

        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("products.edit", ["id" => $products->getId()]),
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form[marque=products]")->form([
            "products[marque]" => "Un produit 2",
            "products[prix]" => floatval(34)
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains("div.alert-success", "Votre produit a été modifié avec succès !");

        $this->assertRouteSame("products");
    }

    public function testIfDeleteProductsIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        $user = $entityManager->find(User::class, 1);
        $products = $entityManager->getRepository(Products::class)->findOneBy([
            "user" => $user
        ]);

        $client->loginUser($user);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("products.delete", ["id" => $products->getId()]),
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains("div.alert-success", "Votre produit a été supprimé avec succès !");

        $this->assertRouteSame("products");
    }
}
