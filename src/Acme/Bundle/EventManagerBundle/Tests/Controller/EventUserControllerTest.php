<?php

namespace Acme\Bundle\EventManagerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventUserControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testPastevents()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pastEvents');
    }

    public function testCurrentevents()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/currentEvents');
    }

}
