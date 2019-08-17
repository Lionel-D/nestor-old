<?php

namespace App\Tests\Security;

use App\Tests\ProjectTestCase;

/**
 * Class SecurityControllerTest
 * @package App\Tests
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class SecurityControllerTest extends ProjectTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testLoginSuccessful()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');

        $form = $crawler->selectButton('login_submit')->form();

        $form['email']    = 'hello@lionel-d.com';
        $form['password'] = 'admin';

        $this->client->submit($form);

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
    }

    public function testLoginFailed()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');

        $form = $crawler->selectButton('login_submit')->form();

        $form['email']    = 'fake@email.com';
        $form['password'] = 'azerty';

        $this->client->submit($form);

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.alert-danger', 'Email could not be found.');
    }

    public function testLoginAsAlreadyAuthenticated()
    {
        $this->assertLoggedAsAdmin();

        $this->client->request('GET', '/login');

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
    }

    public function testLogout()
    {
        $this->assertLoggedAsAdmin();

        $this->client->request('GET', '/logout');

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
