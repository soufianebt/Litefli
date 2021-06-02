<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceCentreController extends AbstractController
{
    /**
     * @Route("/espace/centre", name="espace_centre")
     */
    public function index(): Response
    {
        return $this->render('espace_centre/index.html.twig', [
            'controller_name' => 'EspaceCentreController',
        ]);
    }
}
