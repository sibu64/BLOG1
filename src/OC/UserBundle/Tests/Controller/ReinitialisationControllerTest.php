<?php

namespace OC\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReinitialisationControllerTest extends WebTestCase
{
    public function testRequete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/requete');
    }

    public function testReinitialisation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reinitialisation');
    }

}
