<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Medcin;
use App\Entity\Tuteur;
use App\Entity\Centre;
use App\Form\RegistrationFormType1;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class Registration1Controller extends AbstractController
{
    private $urlGenerator;



    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {   
        
        $user = new Compte();
        $form = $this->createForm(RegistrationFormType1::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            if($user->getTypeCompte()=='centre'){
                $centre1 = new Centre();
                $centre1->setNomCentre($user->getNomComplet());
                $centre1->setCodePostal($user->getCodePostal());
                $centre1->setUsername($user->getUsername());
                $centre1->setMdp($user->getPassword());
                $centre1->setTypeCompte($user->getTypeCompte());
                $centre1->setEmail($user->getEmail());
                
                    $entityManager1 = $this->getDoctrine()->getManager();
                    $entityManager1->persist($centre1);
                    $entityManager1->flush();
                         
            }

            if($user->getTypeCompte()=='medcin'){
                $user1 = new Medcin();
                $user1->setNomComplet($user->getNomComplet());
                $user1->setCodePostal($user->getCodePostal());
                $user1->setUsername($user->getUsername());
                $user1->setMdp($user->getPassword());
                $user1->setTypeCompte($user->getTypeCompte());
                $user1->setEmail($user->getEmail());
                
                    $entityManager1 = $this->getDoctrine()->getManager();
                    $entityManager1->persist($user1);
                    $entityManager1->flush();
                         
            }

            if($user->getTypeCompte()=='tuteur'){
                $user2 = new Tuteur();
                $user2->setNomComplet($user->getNomComplet());
                $user2->setCodePostal($user->getCodePostal());
                $user2->setUsername($user->getUsername());
                $user2->setMdp($user->getPassword());
                $user2->setTypeCompte($user->getTypeCompte());
                $user2->setEmail($user->getEmail());
                $user2->setValidation(0);
                $user2->setIdCentre(0);
                
                    $entityManager2 = $this->getDoctrine()->getManager();
                    $entityManager2->persist($user2);
                    $entityManager2->flush();
                    // do anything else you need here, like send an email
                    
                    
            }
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );

            
        }
        
        

        return $this->render('registration1/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);

        
    }

    



    
}
