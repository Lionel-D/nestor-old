<?php

namespace App\Tests\Admin;

use App\Tests\ProjectTestCase;

/**
 * Class UserControllerTest
 * @package App\Tests\Admin
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class UserControllerTest extends ProjectTestCase
{
    public function testUsersListDisplayAsAuthenticatedAdmin()
    {
        $this->assertLoggedAsAdmin();

        $this->client->request('GET', '/admin/users');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Users list');
    }

    public function testUserDetailDisplayAsAuthenticatedAdmin()
    {
        $this->assertLoggedAsAdmin();

        $crawler = $this->client->request('GET', '/admin/users');

        $link = $crawler->filter('a.btn-secondary')->eq(1)->link();

        $this->client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'User John Doe');
    }

    public function testUserDeleteActionAsAuthenticatedAdmin()
    {
        $this->assertLoggedAsAdmin();

        $crawler = $this->client->request('GET', '/admin/users');

        $link = $crawler->filter('a.btn-danger')->eq(1)->link();

        $this->client->click($link);

        $this->assertResponseRedirects('/admin/users');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert-success', 'User NewUser (new@user.com) successfully deleted.');
    }
}
