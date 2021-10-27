<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GaleryController extends AbstractController
{
    /**
     * @Route("/galery", name="galery")
     */
    public function index(): Response
    {
        return $this->render('galery/index.html.twig', [
            'controller_name' => 'GaleryController',
        ]);
    }
}
