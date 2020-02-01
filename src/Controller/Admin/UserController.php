<?php

namespace App\Controller\Admin;

use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller\Admin
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     * @param UserManager $userManager
     * @return Response
     */
    public function index(UserManager $userManager)
    {
        $usersList = $userManager->getUsersList();

        return $this->render('admin/user/index.html.twig', [
            'users_list' => $usersList,
        ]);
    }

    /**
     * @Route("/admin/users/detail/{id}", name="admin_users_detail", requirements={"id"="\d+"})
     * @param UserManager $userManager
     * @param int         $id
     * @return Response
     */
    public function read(UserManager $userManager, $id)
    {
        $user = $userManager->getUser($id);

        return $this->render('admin/user/detail.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/users/delete/{id}", name="admin_users_delete", requirements={"id"="\d+"})
     * @param UserManager $userManager
     * @param             $id
     * @return RedirectResponse
     */
    public function delete(UserManager $userManager, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $message = $userManager->deleteUser($id);

        $this->addFlash('success', $message);

        return $this->redirectToRoute('admin_users');
    }
}
