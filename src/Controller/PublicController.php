<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PublicController
 * @package App\Controller
 * @author  Lionel DAELEMANS <hello@lionel-d.com>
 */
class PublicController extends AbstractController
{
    /**
     * @Route("/", name="public_homepage")
     * @return Response
     */
    public function index()
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
}
