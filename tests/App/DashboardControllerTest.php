<?php

namespace App\Tests\App;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * Class DashboardControllerTest
 * @package App\Tests\App
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class DashboardControllerTest extends WebTestCase
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
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testDashboardDisplay()
    {
        $this->logIn();

        $this->client->request('GET', '/app/dashboard');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DashboardController!');
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
