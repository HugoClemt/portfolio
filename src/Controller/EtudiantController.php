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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EtudiantController extends AbstractController
{

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
        
        return $this->render('etudiant/accueil.html.twig', ['pRP' => $RPaModifier, 'pStages' => $stages]);
    }

    public function consultoModifierEtudiant($etudiant_id, Request $request)
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
            $form = $this->createForm(EtudiantInfoType::class, $etudiant);
            $form->handleRequest($request);
            //var_dump($etudiant) ;
            if($form->isSubmitted() ){
                $etudiant = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($etudiant);
                $entityManager->flush();
                $this->addFlash('success', 'Profil modifié avec succès !');
                 return $this->render('etudiant/consulter.html.twig', array('form'=>$form->createView(), 'pEtudiant' => $etudiant));
            }
            else{  
                return $this->render('etudiant/consulter.html.twig', array('form'=>$form->createView(), 'pEtudiant' => $etudiant));
            }

        }
    }    


    

    
        public function ajouterEtudiant(Request $request){
                

                
                $etudiant = new etudiant();
                $form = $this->createForm(AjoutEtudiantType::class, $etudiant);
                $form->handleRequest($request);
             
                if ($form->isSubmitted() && $form->isValid()) {
             
                        $etudiant = $form->getData();
             
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($etudiant);
                        $entityManager->flush();
             
                    return $this->render('etudiant/consulter.html.twig', ['pEtudiant' => $etudiant,]);
                }
                else
                    {                       
                        return $this->render('etudiant/ajouter.html.twig', array('form' => $form->createView(),));
                }

}
}


