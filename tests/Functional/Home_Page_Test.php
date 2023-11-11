<?php

namespace App\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Home_Page_Test extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $button = $crawler->selectButton('SignUp');
        $this->assertEquals(1, count($button));

        $products = $crawler->filter('.products .card');
        $this->assertEquals(3, count($products));

        $arrivages = $crawler->filter('.arrivages .card');
        $this->assertEquals(3, count($arrivages));

        $review = $crawler->filter('.review .card');
        $this->assertEquals(1, count($review));


        $this->assertSelectorTextContains('h3', 'G.Parrot');
    }
}
