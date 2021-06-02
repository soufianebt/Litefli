<?php

namespace App\Controller;
use App\Entity\Tuteur;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValideAccountsController extends AbstractController
{
    /**
     * @Route("/valide/accounts", name="consulte_accounts")
     */
    public function index(): Response
    {
      // GET TUTEUR AND BABY DATA FROM DATABASE
      $entityManager = $this->getDoctrine()->getRepository(Tuteur::class);
      $tuteurs = $entityManager->findAll();


      return $this->render('consulte_accounts/babyFiles.html.twig',['response'=>$tuteurs]);
    }



     /**
     * @Route("/valide/valideAccount", name="consulte_valide")
     */
    public function valider(Request $request,EntityManagerInterface $em): Response
    {

      if( $request->isMethod('GET')  && isset($_GET['consulterid']) ){

          $id = $_GET['consulterid'];
          $entityManager = $this->getDoctrine()->getRepository(Tuteur::class);
          $tuteur = $entityManager->findOneBy(['id'=>$id,]);

          // REDIRECT TO DATA TO consult_accounts/babyDetails.html.twig
          return $this->render('consulte_accounts/babyDetails.html.twig',['tuteur'=>$tuteur]);

      }


    }

     /**
     * @Route("/valide/traiter", name="consulte_traiter")
     */
    public function traiter(Request $request,EntityManagerInterface $em): Response
    {

      if( $request->isMethod('GET') ){

          if( isset($_GET['cvalider']) ){

              // VALIDER LE DOCIER
              $repository = $em->getRepository(Tuteur::class);
              $tuteur = $repository->findOneBy(['id'=>$_GET['cvalider'],]);
              $tuteur->setValidation(1);
              //dd($tuteur);
              //$entityManager->persist($tuteur);
              $em->persist($tuteur);
              $em->flush();

              return $this->redirectToRoute('consulte_accounts');

          }elseif( isset($_GET['csupprimer']) ){

              // SUPPRIMER LE DOCIER
              $id = $_GET['csupprimer'];
              $repository = $em->getRepository(Tuteur::class);
              $query = $em->createQuery("DELETE App\Entity\Tuteur t WHERE t.id =$id ");
              $query->execute();
              // REDIRECT TO DATA TO home
              return $this->redirectToRoute('consulte_accounts');

          }elseif( isset($_GET['cunvalide'])){

              // SUPPRIMER LA VALIDATION DE docier
              $repository = $em->getRepository(Tuteur::class);
              $tuteur = $repository->findOneBy(['id'=>$_GET['cunvalide'],]);
              $tuteur->setValidation(0);
              $em->persist($tuteur);
              $em->flush();
              // REDIRECT TO DATA TO home
              return $this->redirectToRoute('consulte_accounts');




          }else{
            //
          }

          // REDIRECT TO DATA TO consult_accounts/babyDetails.html.twig
          return $this->render('consulte_accounts/babyDetails.html.twig',['tuteur'=>$tuteur]);

      }


    }




    // POUR CHERCHER FACILEMENT UN BEBE AVEC SON NOM COMPLETE
    /**
     * @Route("/valide/search", name="consulte_search")
     */
    public function searchTuteur(Request $request,EntityManagerInterface $em): Response
    {

      if( $request->isMethod('GET')  && isset($_GET['sh']) ){

          $nomCompletBebe = $_GET['sh'];
          $repository = $em->getRepository(Tuteur::class);
          $tuteur = $repository->findBy(['nomCompletBebe'=>$nomCompletBebe,]);

          if(sizeof($tuteur)>0){
            // REDIRECT TO DATA TO consult_accounts/babyDetails.html.twig
            return $this->render('consulte_accounts/babyFiles.html.twig',['response'=>$tuteur]);
          }else{
            return $this->render('consulte_accounts/babyFiles.html.twig',['rempty'=>"Empty result"]);
          }


      }

    }
}
