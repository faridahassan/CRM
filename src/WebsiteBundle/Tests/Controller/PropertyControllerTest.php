<?php

namespace WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PropertyControllerTest extends WebTestCase
{
    public function testManageproperty()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/manageProperty');
    }

}
