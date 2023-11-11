<?php

namespace App\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactTest extends WebTestCase
{
    public function testContact(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'FORMULAIRE DE CONTACT');

        // Récupérer le formulaire 
        $submitButton = $crawler->selectButton('Valider');
        $form = $submitButton->form();

        $form["contact[fullName]"] = "Julie de la Ferrand";
        $form["contact[email]"] = "margaux.joseph@yahoo.fr";
        $form["contact[subject]"] = "Test";
        $form["contact[message]"] = "Test";

        // Soumettre le formulaire
        $client->submit($form);

        //Vérifier le statut HTTP
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        // Vérifier l'envoie de l'email
        $this->assertEmailCount(1);

        $client->followRedirect();

        // Vérifier la présence du message de succès
        $this->assertSelectorTextContains(
            "div.alert.alert-succes.mt-4",
            "Votre message a bien été enregistré avec succès"
        );
    }
}
