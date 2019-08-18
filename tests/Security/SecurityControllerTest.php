<?php

namespace App\Tests\Security;

use App\Tests\ProjectTestCase;
use Symfony\Component\DomCrawler\Crawler;

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
        $crawler = $this->successfullyLoadLoginPage();

        $this->fillAndSubmitLoginForm($crawler, 'john@doe.com', 'password');

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
    }

    public function testLoginFailed()
    {
        $crawler = $this->successfullyLoadLoginPage();

        $this->fillAndSubmitLoginForm($crawler, 'fake@email.com', 'azerty');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.alert-danger', 'Email could not be found.');
    }

    public function testLoginAsAlreadyAuthenticated()
    {
        $this->assertLoggedAsUser();

        $this->client->request('GET', '/login');

        $this->assertResponseRedirects('/app/dashboard');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
    }

    public function testLogout()
    {
        $this->assertLoggedAsUser();

        $this->client->request('GET', '/logout');

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @return Crawler
     */
    private function successfullyLoadLoginPage()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');

        return $crawler;
    }

    /**
     * @param Crawler $crawler
     * @param string  $email
     * @param string  $password
     */
    private function fillAndSubmitLoginForm(Crawler $crawler, $email, $password)
    {
        $form = $crawler->selectButton('login_submit')->form();

        $form['email']    = $email;
        $form['password'] = $password;

        $this->client->submit($form);
    }
}
