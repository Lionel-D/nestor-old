<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userSuperAdmin = new User();

        $userSuperAdmin->setName('Lionel');
        $userSuperAdmin->setEmail('hello@lionel-d.com');
        $userSuperAdmin->setPassword($this->passwordEncoder->encodePassword($userSuperAdmin, 'superadmin'));
        $userSuperAdmin->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->persist($userSuperAdmin);

        $userAdmin = new User();

        $userAdmin->setName('Admin');
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setPassword($this->passwordEncoder->encodePassword($userAdmin, 'admin'));
        $userAdmin->setRoles(['ROLE_ADMIN']);

        $manager->persist($userAdmin);

        $user = new User();

        $user->setName('John Doe');
        $user->setEmail('john@doe.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));

        $manager->persist($user);

        $manager->flush();
    }
}
