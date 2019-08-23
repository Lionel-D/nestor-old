<?php

namespace App\Tests\Website;

use App\Tests\ProjectTestCase;

/**
 * Class HomeControllerTest
 * @package App\Tests\Website
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class HomeControllerTest extends ProjectTestCase
{
    public function testHomepageDisplay()
    {
        $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }
}
