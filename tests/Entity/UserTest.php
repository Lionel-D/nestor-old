<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @var User $user
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testEmail()
    {
        $this->user->setEmail('hello@lionel-d.com');

        $this->assertTrue($this->user->getEmail() == 'hello@lionel-d.com');
    }

    public function testUsername()
    {
        $this->user->setEmail('hello@lionel-d.com');

        $this->assertTrue($this->user->getUsername() == 'hello@lionel-d.com');
    }

    public function testRoles()
    {
        $this->assertTrue($this->user->getRoles() == ['ROLE_USER']);

        $this->user->setRoles(['ROLE_ADMIN']);

        $this->assertTrue($this->user->getRoles() == ['ROLE_ADMIN', 'ROLE_USER']);
    }

    public function testPassword()
    {
        $this->user->setPassword('Hash&SaltPassword');

        $this->assertTrue($this->user->getPassword() == 'Hash&SaltPassword');
    }

    public function testName()
    {
        $this->user->setName('Lionel');

        $this->assertTrue($this->user->getName() == 'Lionel');
    }
}
