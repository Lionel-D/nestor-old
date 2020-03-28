<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserManager
 * @package App\Service
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class UserManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserManager constructor.
     * @param UserRepository         $userRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return User[]
     */
    public function getUsersList()
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getUser($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException('This user does not exist.');
        }

        return $user;
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteUser($id)
    {
        $user = $this->getUser($id);

        $message = 'User ' . $user->getName() . ' (' . $user->getEmail() . ') successfully deleted.';

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $message;
    }
}
