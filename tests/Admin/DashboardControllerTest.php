<?php

namespace App\Tests\Admin;

use App\Tests\ProjectTestCase;

/**
 * Class DashboardControllerTest
 * @package App\Tests\Admin
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class DashboardControllerTest extends ProjectTestCase
{
    public function testDashboardDisplayAsAuthenticatedAdmin()
    {
        $this->assertLoggedAsAdmin();

        $this->client->request('GET', '/admin/dashboard');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello AdminDashboardController!');
    }

    public function testDashboardDisplayAsAuthenticatedUser()
    {
        $this->assertLoggedAsUser();

        $this->client->request('GET', '/admin/dashboard');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testDashboardDisplayAsAnonymous()
    {
        $this->client->request('GET', '/admin/dashboard');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.card-header', 'Please sign in');
    }
}
