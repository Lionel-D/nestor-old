<?php

namespace App\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller\Site
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="site_homepage")
     * @return Response
     */
    public function index()
    {
        return $this->render('site/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
