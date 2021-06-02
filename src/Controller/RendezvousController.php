<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\CentreRepository;
use App\Repository\MedcinRepository;
use App\Repository\RendezvousRepository;
use App\Repository\TuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/rendezvous")
 */
class RendezvousController extends AbstractController
{
    private $security;
    private $tuteurRepository;
    private $centreRepository;
    private $MedcineRepository;
    public function __construct(MedcinRepository $MedcineRepository ,TuteurRepository $tuteurRepository, CentreRepository $centreRepository, Security $security)
    {   $this->tuteurRepository = $tuteurRepository;
        $this->centreRepository = $centreRepository;
        $this->MedcineRepository = $MedcineRepository;
        $this->security= $security;
    }

    /**
     * @Route("/", name="rendezvous_index", methods={"GET"})
     */
    public function index(RendezvousRepository $rendezvousRepository, TuteurRepository  $tuteurRepository): Response
    {
        $user=$this->security->getUser();


        $tuteurs =  $tuteurRepository->findBy(['codePostal'=>$user->getCodePostal()]);

        return $this->render('rendezvous/index.html.twig', [
            'Tutures' => $tuteurs,
        ]);
    }

    /**
     * @Route("/new", name="rendezvous_new", methods={"GET","POST"})
     */
    public function new(Request $request,CentreRepository $centreRepository, TuteurRepository  $tuteurRepository, MedcinRepository $medcinRepository): Response
    {
        $tuteur_id = (int) substr($request->getQueryString(), 10);
        $tuteur =  $tuteurRepository->findBy(['id'=>$tuteur_id]);
        $user=$this->security->getUser();
        $medcine = $medcinRepository->findBy(['email' => $user->getemail()]);
        $centre = $centreRepository->findBy(['codePostal'=>$user->getCodePostal()]);

        $rendezvou = new Rendezvous();

        $rendezvou ->setCentreID($centre[0]->getid());
        $rendezvou->setParentID($tuteur[0]->getid());
        $rendezvou->setMedcineID($medcine[0]->getid());
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezvou);
            $entityManager->flush();

            return $this->redirectToRoute('rendezvous_index');
        }

        return $this->render('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/show/{id}", name="rendezvous_showone", methods={"GET"})
     */
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }

    /**
     * @Route("/showAll", name="rendezvous_show", methods={"GET"})
     */
    public function showone(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="rendezvous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rendezvous $rendezvou): Response
    {
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendezvous_index');
        }

        return $this->render('rendezvous/edit.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendezvous_delete", methods={"POST"})
     */
    public function delete(Request $request, Rendezvous $rendezvou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezvou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendezvous_index');
    }
}
