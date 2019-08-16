<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * Class SecurityControllerTest
 * @package App\Tests
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function setUp(): void
    {
        $this->client        = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
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

    public function testLogout()
    {
        $this->logIn();

        $this->client->request('GET', '/logout');

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello HomeController!');
    }

    private function logIn()
    {
        /** @var UserInterface $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'hello@lionel-d.com']);
        $session = $this->client->getContainer()->get('session');
        $firewall = 'main';

        $token = new PostAuthenticationGuardToken($user, '_security_'.$firewall, ['ROLE_ADMIN']);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }
}
