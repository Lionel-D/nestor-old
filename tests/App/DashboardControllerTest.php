<?php

namespace App\Tests\App;

use App\Tests\ProjectTestCase;

/**
 * Class DashboardControllerTest
 * @package App\Tests\App
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class DashboardControllerTest extends ProjectTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testDashboardDisplayAsAuthenticated()
    {
        $this->assertLoggedAsAdmin();

        $this->client->request('GET', '/app/dashboard');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
    }

    public function testDashboardDisplayAsAnonymous()
    {
        $this->client->request('GET', '/app/dashboard');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
