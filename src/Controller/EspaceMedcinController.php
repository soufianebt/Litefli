<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceMedcinController extends AbstractController
{
    /**
     * @Route("/espace/medcin", name="espace_medcin")
     */
    public function index(): Response
    {
        return $this->render('espace_medcin/index.html.twig', [
            'controller_name' => 'EspaceMedcinController',
        ]);
    }
}
