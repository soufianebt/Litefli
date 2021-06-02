<?php

namespace App\Controller;
use App\Entity\Tuteur;
use App\Entity\Centre;
use App\Repository\TuteurRepository;
use App\Repository\CentreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
class EspaceParentController extends AbstractController
{
    const id=1;
    private $security;
    private $tuteurRepository;
    private $centreRepository;

    public function __construct(TuteurRepository $tuteurRepository, CentreRepository $centreRepository, Security $security)
    {   $this->tuteurRepository = $tuteurRepository;
        $this->centreRepository = $centreRepository;
        $this->security= $security;
    }
    /**
     * @Route("/espace/parent", name="espace_parent")
     */
    public function index(): Response
    {
        return $this->render('espace_parent/index.html.twig', [
            'controller_name' => 'EspaceParentController',
        ]);
        
    }


    /**
     * @Route("/espace/parent/edit", name="app_tuteur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user=$this->security->getUser();
        $user->getEmail();
        $tuteur= $this->tuteurRepository->findOneByEmail($user->getEmail());
        
        $form = $this->createFormBuilder($tuteur)
        ->add('nomCompletBebe')
        ->add('dateNaissance')
        ->add('codePostal')
        ->getForm()
            
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $centre= $this->centreRepository->findOneByCodePostal($tuteur->getCodePostal());
            $tuteur->setIdCentre($centre->getId());
            $em->flush();
            $this->addFlash('success', 'Votre demande a bien été soumise');

            return $this->redirectToRoute('espace_parent');
        }

        return $this->render('espace_parent/edit.html.twig', [
            'tuteur' => $tuteur,
            'form' => $form->createView()
        ]);
    }
}
