<?php

namespace App\Controller;
use App\Form\EtudiantInfoType;
use App\Form\AjoutEtudiantType;
use App\Entity\Etudiant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RP;
use App\Entity\Stage;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Form\MDPModifType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class EtudiantController extends AbstractController
{

    //Fonction d'accueil pour un etudiant
    /*
     * @Route("/etudiant", name="etudiant")
     */
    public function accueilEtudiant($etudiant_id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaModifier = $repository->findBy(
            ['etudiant' => $etudiant_id, 'statut' => 3], array('dateModif'=>'desc'));

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findOneById($etudiant_id);
                                                                    
        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEtudiant($etudiant);

        
        return $this->render('etudiant/accueil.html.twig', ['pRP' => $RPaModifier, 'pStages' => $stages, 'pEtudiant' => $etudiant]);
    }

    //Fonction pour acceder au information du compte etudiant avec la possibilité de changer les données
    public function consultoModifierEtudiant($etudiant_id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {   
        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($etudiant_id);
        if(!$etudiant){
            echo ("etudiant non trouvé");
            throw $this->createNotFoundException('Aucun etudiant trouvé avec l\'id '.$etudiant_id);
        }
        else
        {
            $formEtudiant = $this->createForm(EtudiantInfoType::class, $etudiant);
            $formEtudiant->handleRequest($request);

            $user = $etudiant->getUser();

            $formMDP = $this->createForm(MDPModifType::class, $user);
            $formMDP->handleRequest($request);
            
            //var_dump($etudiant) ;
            if($formEtudiant->isSubmitted()){
                $etudiant = $formEtudiant->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($etudiant);
                $entityManager->flush();
                $userIdentifiant = $etudiant->getUser();
                $userIdentifiant->setUsername(strtolower($etudiant->getPrenom()).".".strtolower($etudiant->getNom()));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userIdentifiant);
                $entityManager->flush();
                $this->addFlash('success', 'Profil modifié avec succès !');
                
                return $this->render('etudiant/consulter.html.twig', array('formEtudiant'=>$formEtudiant->createView(), 'formMDP'=>$formMDP->createView(), 'pEtudiant' => $etudiant));
            }

            elseif($formMDP->isSubmitted()){ 
                $user = $formMDP->getData();
                            $user->setPassword(
                                $passwordEncoder->encodePassword(
                                    $user,
                                    $formMDP->get('password')->getData()
                                )
                            );
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Mot de passe modifié avec succès !');
                
                return $this->render('etudiant/consulter.html.twig', array('formEtudiant'=>$formEtudiant->createView(), 'formMDP'=>$formMDP->createView(), 'pEtudiant' => $etudiant));
            }
            else{  
                echo($user->getSalt());
                return $this->render('etudiant/consulter.html.twig', array('formEtudiant'=>$formEtudiant->createView(), 'formMDP'=>$formMDP->createView(), 'pEtudiant' => $etudiant));
            }

        }
    
    }
       
    //Fonction permet a l'étudiant de changer son mot de passe
    /**
     * @Route(name="MDPModifEtu",path="/MDPModifEtu")
     * @param Request $request
     * @return Response
     */
    public function MDPModifEtu(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $old_password=$_POST["old_password"];
        $new_password=$_POST["new_password"];
        $mdp_modif_password=$_POST["mdp_modif_password"];
        $user_id=$_POST["user_id"];

        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($user_id);

        $output=array();

        $checkPass = $passwordEncoder->isPasswordValid($user, $old_password);
           if($checkPass === true) {
                if($mdp_modif_password == $new_password && $mdp_modif_password != ""){
                    if(preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*\[\]"\';:_\-<>\., =\+\/\\µ~¤£§]).{8,}$^', $mdp_modif_password)){
                        $output[]=array(
                            'statut'=>4);//si output = 4 alors c'est bon
                    }
                    else{
                        $output[]=array(
                            'statut'=>3);//si output = 3 alors mdp trop faible
                    }    
                }
                else{
                    $output[]=array(
                        'statut'=>2);//si output = 2 alors nouveau mdp différent de confirme nouveau mdp
                }   
           } 
           else {
                $output[]=array(
                    'statut'=>1);//si output = 1 alors ancien mdp incorrect
           }
    
     /*   var_dump($themes);
        $json = json_encode($themes);

        $response = new Response();*/
        //            return $response->setContent($json);
        return new JsonResponse($output);

    
    return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }

    //Verification de l'ancien mot de passe et confirmation du nouveaux mot de passe avant de pouvoir changer
    public function change_user_password(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $old_pwd = $request->get('old_password'); 
        $new_pwd = $request->get('new_password'); 
        $new_pwd_confirm = $request->get('new_password_confirm');
        $user = $this->getUser();
        $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);
        if($checkPass === true) {
                   
        } 
        else{
            return new jsonresponse(array('error' => 'The current password is incorrect.'));
        }
    }

}

