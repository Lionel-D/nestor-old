<?php

namespace App\Tests\App;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DashboardControllerTest
 * @package App\Tests\App
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class DashboardControllerTest extends WebTestCase
{
    public function testDashboardDisplay()
    {
        $client = static::createClient();

        $client->request('GET', '/app/dashboard');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
    }
}
