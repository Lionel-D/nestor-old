<?php

namespace App\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\App
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/app/dashboard", name="app_dashboard")
     */
    public function index()
    {
        return $this->render('app/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
