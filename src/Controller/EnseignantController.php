<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RP;
use App\Entity\Enseignant;
use App\Entity\activite;
use App\Entity\Stage;
use App\Entity\User;
use App\Entity\Promotion;
use App\Form\EnseignantInfoType;
use App\Form\MDPModifType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EnseignantController extends AbstractController
{
    /**
     * @Route("/enseignant", name="enseignant")
     */
    public function accueilEnseignant($enseignant_id)
    {
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById($enseignant_id);

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaCommenter = $repository->findBy(
            ['enseignant' => $enseignant_id, 'statut' => 2], array('dateModif'=>'desc'));

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEnseignant($enseignant_id);
        
        return $this->render('enseignant/accueil.html.twig', ['pRP' => $RPaCommenter, 'pStages' => $stages, 'pEnseignant' => $enseignant]);
    }

    public function consultoModifierEnseignant($enseignant_id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {   
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->find($enseignant_id);
        if(!$enseignant){
            echo ("enseignant non trouvé");
            throw $this->createNotFoundException('Aucun enseignant trouvé avec l\'id '.$enseignant_id);
        }
        else
        {

            $formEnseignant = $this->createForm(EnseignantInfoType::class, $enseignant);
            $formEnseignant->handleRequest($request);

            $user = $enseignant->getUser();

            $formMDP = $this->createForm(MDPModifType::class, $user);
            $formMDP->handleRequest($request);
            
            //var_dump($etudiant) ;
            if($formEnseignant->isSubmitted()){
                $enseignant = $formEnseignant->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($enseignant);
                $entityManager->flush();
                $userIdentifiant = $enseignant->getUser();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userIdentifiant);
                $entityManager->flush();
                $this->addFlash('success', 'Profil modifié avec succès !');
                
                return $this->render('enseignant/consulter.html.twig', array('formEnseignant'=>$formEnseignant->createView(), 'formMDP'=>$formMDP->createView(), 'pEnseignant' => $enseignant));
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
                
                return $this->render('enseignant/consulter.html.twig', array('formEnseignant'=>$formEnseignant->createView(), 'formMDP'=>$formMDP->createView(), 'pEnseignant' => $enseignant));
            }
            else{  
                return $this->render('enseignant/consulter.html.twig', array('formEnseignant'=>$formEnseignant->createView(), 'formMDP'=>$formMDP->createView(), 'pEnseignant' => $enseignant));
            }

        }
    
    }
}  
