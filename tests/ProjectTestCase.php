<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

abstract class ProjectTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client        = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function assertLoggedAsUser()
    {
        $this->assertLogged('john@doe.com', ['ROLE_USER']);
    }

    protected function assertLoggedAsAdmin()
    {
        $this->assertLogged('admin@admin.com', ['ROLE_ADMIN']);
    }

    protected function assertLoggedAsSuperAdmin()
    {
        $this->assertLogged('hello@lionel-d.com', ['ROLE_SUPER_ADMIN']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**
     * @param string $email
     * @param array  $roles
     */
    private function assertLogged($email, $roles)
    {
        /** @var UserInterface $user */
        $user     = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        $session  = $this->client->getContainer()->get('session');
        $firewall = 'main';

        $token = new PostAuthenticationGuardToken($user, '_security_'.$firewall, $roles);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }
}
