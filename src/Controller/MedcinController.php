<?php

namespace App\Controller;

use App\Entity\Medcin;
use App\Form\MedcinType;
use App\Repository\MedcinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Compte;
/**
 * @Route("/medcin")
 */
class MedcinController extends AbstractController
{
    /**
     * @Route("/", name="medcin_index", methods={"GET"})
     */
    public function index(MedcinRepository $medcinRepository): Response
    {
        return $this->render('medcin/index.html.twig', [
            'medcins' => $medcinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="medcin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $medcin = new Medcin();
        $form = $this->createForm(MedcinType::class, $medcin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medcin);
            $entityManager->flush();
            $user = new Compte();

            $user->setUsername($medcin->getUsername());
                $user->setPassword($medcin->getMdp());
                $user->setTypeCompte($medcin->getTypeCompte());
                $user->setEmail($medcin->getEmail());
                $user->setCodePostal($medcin->getCodePostal());
                $user->setNomComplet($medcin->getNomComplet());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();    

            return $this->redirectToRoute('medcin_index');
        }

        return $this->render('medcin/new.html.twig', [
            'medcin' => $medcin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medcin_show", methods={"GET"})
     */
    public function show(Medcin $medcin): Response
    {
        return $this->render('medcin/show.html.twig', [
            'medcin' => $medcin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medcin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Medcin $medcin): Response
    {
        $form = $this->createForm(MedcinType::class, $medcin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medcin_index');
        }

        return $this->render('medcin/edit.html.twig', [
            'medcin' => $medcin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medcin_delete", methods={"POST"})
     */
    public function delete(Request $request, Medcin $medcin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medcin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medcin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medcin_index');
    }
}
