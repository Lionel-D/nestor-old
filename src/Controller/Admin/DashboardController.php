<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}
