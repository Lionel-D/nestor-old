<?php

namespace App\Tests\Website;

use App\Tests\ProjectTestCase;

/**
 * Class HomeControllerTest
 * @package App\Tests\Site
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class HomeControllerTest extends ProjectTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testHomepageDisplay()
    {
        $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
