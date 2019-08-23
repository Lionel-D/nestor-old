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
    public function testDashboardDisplayAsAuthenticatedUser()
    {
        $this->assertLoggedAsUser();

        $this->client->request('GET', '/app/dashboard');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello AppDashboardController!');
    }

    public function testDashboardDisplayAsAnonymous()
    {
        $this->client->request('GET', '/app/dashboard');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.card-header', 'Please sign in');
    }
}
