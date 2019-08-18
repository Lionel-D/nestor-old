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
        /** @var UserInterface $user */
        $user     = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'john@doe.com']);
        $session  = $this->client->getContainer()->get('session');
        $firewall = 'main';

        $token = new PostAuthenticationGuardToken($user, '_security_'.$firewall, ['ROLE_USER']);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }

    protected function assertLoggedAsAdmin()
    {
        /** @var UserInterface $user */
        $user     = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'admin@admin.com']);
        $session  = $this->client->getContainer()->get('session');
        $firewall = 'main';

        $token = new PostAuthenticationGuardToken($user, '_security_'.$firewall, ['ROLE_ADMIN']);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }

    protected function assertLoggedAsSuperAdmin()
    {
        /** @var UserInterface $user */
        $user     = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'hello@lionel-d.com']);
        $session  = $this->client->getContainer()->get('session');
        $firewall = 'main';

        $token = new PostAuthenticationGuardToken($user, '_security_'.$firewall, ['ROLE_SUPER_ADMIN']);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}