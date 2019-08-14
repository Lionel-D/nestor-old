<?php

namespace App\Tests\Site;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class HomeControllerTest
 * @package App\Tests\Site
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class HomeControllerTest extends WebTestCase
{
    public function testHomepageDisplay()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }
}
