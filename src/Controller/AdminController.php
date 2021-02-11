<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Form\EtudiantType;
use App\Form\EnseignantType;
use App\Entity\User;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
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

    public function ajouterPromotion(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotion = $form->getData();
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->render('admin/listerPromotion.html.twig', ['promotion' => $promotion,]);
        }
        else
        {

            return $this->render('admin/ajouterPromotion.html.twig', array('form' => $form->createView(), ));
        }
    }

    public function admin(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/index.html.twig', ['users' => $users]);

    }

    public function accueil(){
        
        return $this->render('admin/accueil.html.twig');
    }

    public function ajouterEtudiant(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById(1);

        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        $etudiant->setMail('example@example.com');
        $etudiant->setMobile('XXXXXXXXXX');
        $etudiant->setDatenaiss(new \DateTime('01/01'));
        $etudiant->setAdrperso('AdrPerso');
        $etudiant->setVille('Caen');
        $etudiant->setCopos('14000');
        $etudiant->setStatut('active');
        $etudiant->setPromotion($promotion);
        
        

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
    
    public function listerEnseignant(Request $request){

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findAll();

        return $this->render('admin/listerEnseignant.html.twig', array('pEnseignant' => $enseignant));
    }

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

    public function listerEtudiant(Request $request){

        $etudiants = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findAll();

        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        return $this->render('admin/listerEtudiant.html.twig', array('pEtudiants' => $etudiants, 'form' => $form->createView()));
    }

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
                'date'=>$etudiant->getDateNaiss()->format('d/m/Y')
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
}