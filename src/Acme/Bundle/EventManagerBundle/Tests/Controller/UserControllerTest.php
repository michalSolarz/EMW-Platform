<?php

namespace Acme\Bundle\EventManagerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testListusers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listUsers');
    }

    public function testDisplayuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/displayUser');
    }

    public function testManageuserroles()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/manageUserRoles');
    }

}
