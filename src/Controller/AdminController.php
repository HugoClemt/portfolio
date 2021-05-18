<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Form\EtudiantType;
use App\Form\EtudiantInfoType;
use App\Form\EnseignantType;
use App\Form\EnseignantInfoType;
use App\Entity\User;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
use App\Controller\OutilChangePromo;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
     public function index(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user

        return $this->redirectToRoute('app_login', [
        ]);

    }

    //Function pour accueil une fois connecter en admin
    public function accueil(){
        
        return $this->render('admin/accueil.html.twig');
    }

    //Function pour ajouter un etudiant avec des valeurs par defaut pour le mobile, date de naissance, adresse.
    public function ajouterEtudiant(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById(1);

        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        $etudiant->setMobile('XXXXXXXXXX');
        $etudiant->setDatenaiss(new \DateTime('01/01'));
        $etudiant->setAdrperso('AdrPerso');
        $etudiant->setVille('Caen');
        $etudiant->setCopos('14000');
        $etudiant->setStatut('active');

        if ($form->isSubmitted()) {
     
            $etudiant = $form->getData();
            $user = new User();
            $user->setUsername(strtolower($etudiant->getPrenom()).".".strtolower($etudiant->getNom()));
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    'abcd'
                )
            );
            $roles[]='ROLE_ETUDIANT';
            $user->setRoles($roles);

            $etudiant->setUser($user);
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('admin/accueil.html.twig');
        }
        else
            {                       
            return $this->render('admin/ajouterEtudiant.html.twig', array('form' => $form->createView(),));
        }
    }

    //Ajouter un enseignant avec des valeurs par defaut pour l'adresse mail et le mot de passe.
    public function ajouterEnseignant(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);
        $enseignant->setMail('example@example.com');
        $enseignant->setNiveau('1');
        $enseignant->setStatut('valide');      
        

        if ($form->isSubmitted()) {
     
            $enseignant = $form->getData();
            $user = new User();
            $user->setUsername(strtolower($enseignant->getPrenom()).".".strtolower($enseignant->getNom()));
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    'dcba'
                )
            );
            $roles[]='ROLE_ENSEIGNANT';
            $user->setRoles($roles);

            $enseignant->setUser($user);
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('admin/accueil.html.twig');
        }
        else
            {                       
            return $this->render('admin/ajouterEnseignant.html.twig', array('form' => $form->createView(),));
        }
    }
    
    //Fonction pour afficher la liste de tout les enseignants inscrit sur le portfolio
    public function listerEnseignant(Request $request){

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findAll();

        return $this->render('admin/listerEnseignant.html.twig', array('pEnseignant' => $enseignant));
    }

    //Function pour réinitialiser le mot de passe d'un compte enseignant
    public function REmpdEnseignant($user_id, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($user_id);

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                '1234'
            )
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'MDP réinitialisé');

        #return $this->render('admin/listerEtudiant.html.twig', array('pUser' => $user));   
        return $this->redirectToRoute('listerEnseignant');
        
    } 

    //Fonction pour lister tout les etudiants inscrit sur le portfolio
    public function listerEtudiant(Request $request){

        $etudiants = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findAll();

        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);
        $formPromo = $this->createForm(PromotionType::class, $promotion);
        $formPromo->handleRequest($request);
        

        return $this->render('admin/listerEtudiant.html.twig', array('pEtudiants' => $etudiants, 'form' => $form->createView(), 'formPromo' => $formPromo->createView()));
    }

    //Fontion pour afficher les étudiants selon leur promotion
    /**
     * @Route(name="afficherEtudiantPromo",path="/afficherEtudiantPromo")
     * @param Request $request
     * @return Response
     */
    public function afficherEtudiantPromo(Request $request)
    {
        $numeroption=$_POST["numeroption"];

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById($numeroption);

        $etudiants = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findBy(array('promotion' => $promotion), array('nom' => 'ASC'));

        $output=array();
        if ($request->isXmlHttpRequest()) {
        foreach ($etudiants as $etudiant){


        if (!$etudiant->getUser()){
            $output[]=array(
                'id'=>$etudiant->getId(),
                'nom'=>$etudiant->getNom(),
                'prenom'=>$etudiant->getPrenom(),
            );}
        else{
            $output[]=array(
                'id'=>$etudiant->getId(),
                'user_id'=>$etudiant->getUser()->getId(),
                'nom'=>$etudiant->getNom(),
                'prenom'=>$etudiant->getPrenom(),
                'username'=>$etudiant->getUser()->getUsername(),
                'date'=>$etudiant->getDateNaiss()->format('d/m/Y')
            );}
        }
        return new JsonResponse($output);

    }
    return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }

    //Fonction pour réinitialiser le mot de passe d'un compte étudiant
    public function REmpdEtudiant($user_id, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($user_id);

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                '1234'
            )
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'MDP réinitialisé');

        #return $this->render('admin/listerEtudiant.html.twig', array('pUser' => $user));   
        return $this->redirectToRoute('listerEtudiant');

    }

    //Fonction pour consulter les informations d'un compte étudiant avec la possibilté de modifier certaine données
    public function ConsulterEtudiantAdmin($user_id, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($user_id);

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($user->getEtudiant()->getId());

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->find($user->getEtudiant()->getPromotion()->getId());

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        $etudiant->setPromotion($promotion);

        if($form->isSubmitted()){

            $etudiant = $form->getData();
            $user->setUsername(strtolower($etudiant->getPrenom()).".".strtolower($etudiant->getNom()));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('admin/consulterEtudiant.html.twig', array('form'=>$form->createView(), 'pEtudiant' => $etudiant, 'pUser' => $user));
        }
        else
        {
            return $this->render('admin/consulterEtudiant.html.twig', array('form'=>$form->createView(), 'pEtudiant' => $etudiant, 'pUser' => $user));
        }
    }

    //Fonction pour consulter les informations d'un compte enseignant avec la possibilté de modifier certaine données
    public function ConsulterEnseignantAdmin($user_id, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($user_id);

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->find($user->getEnseignant()->getId());

        $promotions = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findAll();

        $form = $this->createForm(EnseignantInfoType::class, $enseignant);
        $form->handleRequest($request);
        //$etudiant->setPromotion($promotion);

        if($form->isSubmitted()){

            $enseignant = $form->getData();
            $user->setUsername(strtolower($enseignant->getPrenom()).".".strtolower($enseignant->getNom()));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('admin/consulterEnseignant.html.twig', array('form'=>$form->createView(), 'pEnseignant' => $enseignant, 'pUser' => $user, 'pPromotions' => $promotions));
        }
        else
        {
            return $this->render('admin/consulterEnseignant.html.twig', array('form'=>$form->createView(), 'pEnseignant' => $enseignant, 'pUser' => $user, 'pPromotions' => $promotions));
        }
    }

    //Fonction pour affecter un enseignant à une ou plusieurs promotions
    /**
     * @Route(name="AffecterPromotion",path="/AffecterPromotion")
     * @param Request $request
     */
    public function AffecterPromotion(Request $request){

        $numeroEnseignant=$_POST["numeroEnseignant"];
        $selectedString=$_POST["selectedString"];
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById($numeroEnseignant);

     

        $selectedString = str_replace("\"", "", $selectedString);

        $selectedString = str_replace("[", "", $selectedString);

        $selectedString = str_replace("]", "", $selectedString);

        $selected = explode(",", $selectedString);

        foreach ($selected as $promotion_id){
            if(!$promotion_id){
            }
            else{
                $promotion = $this->getDoctrine()
                ->getRepository(Promotion::class)
                ->findOneById($promotion_id);
                $enseignant->addPromotion($promotion);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($enseignant);
                $entityManager->flush();
            }
           
        }
        $output=array();
        return new JsonResponse($output);
    }

    //Fonction pour consulter les informations d'un compte enseignant avec la possibilté de modifier certaine données
    public function SupprimerEnseignantAdmin($user_id){

        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($user_id);

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->find($user->getEnseignant()->getId());
        $enseignant->setStatut("archive");

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($enseignant);
        $entityManager->flush();

        return $this->redirectToRoute('listerEnseignant');    
    }

    //Fonction pour deplacer un etudiant d'un promotion à une autre promotion
    /**
     * @Route(name="DeplacerPromo",path="/DeplacerPromo")
     * @param Request $request
     */
    public function DeplacerPromo(Request $request){

        $numeroPromo=$_POST["numeroPromo"];
        $selectedString=$_POST["selectedString"];
        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById($numeroPromo);

        $selectedString = str_replace("\"", "", $selectedString);

        $selectedString = str_replace("[", "", $selectedString);

        $selectedString = str_replace("]", "", $selectedString);

        $selected = explode(",", $selectedString);

        foreach ($selected as $etu_id){
            if(!$etu_id){
            }
            else{
                $etudiant = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->findOneById($etu_id);
                $etudiant->setPromotion($promotion);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($etudiant);
                $entityManager->flush();
                $this->addFlash('success', 'Nouvelle affectation réalisée avec succès !');
            }
           
        }
        $output=array();
        return new JsonResponse($output);
    }
}
        