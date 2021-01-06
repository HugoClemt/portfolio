<?php

namespace App\Controller;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Entity\Stage;
use App\Controller\StageController;
use App\Entity\TacheSemaine;
use App\Entity\RPActivite;
use App\Entity\Enseignant;
use App\Form\StageType;
use App\Entity\Promotion;

use Symfony\Component\HttpFoundation\Request;


use App\Entity\Matiere;
use App\Entity\SemaineStage;


class StageController extends AbstractController
{
    /**
     * @Route("/stage", name="stage")
     */
     public function consulterStage($stage_id)
     {

         $stage = $this->getDoctrine()
         ->getRepository(Stage::class)
         ->find($stage_id);


         return $this->render('stage/consulter.html.twig', ['pStage' => $stage]);
     }



     public function ListerAncienStages()
    {

        
        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findAll();
         return $this->render('stage/lister.html.twig', [
            'pStages' => $stages,]);   
    }

    public function ListerStagesAffect($enseignant_id){

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEnseignant($enseignant_id);

        return $this->render('stage/lister.html.twig', [
            'pStages' => $stages,]);

    }

    public function ListerStagesEtudiant($etudiant_id){

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findOneById($etudiant_id);

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEtudiant($etudiant);



        return $this->render('stage/lister.html.twig', [
            'pStages' => $stages,]);
    }



    public function ListerStagesPromo($promotion_id){

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById($promotion_id);

        $etudiants = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findByPromotion($promotion);

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEtudiant($etudiants,array('etudiant'=>'asc'));


        $stage1annee = array();
        $stage2annee = array();


        foreach ($stages as $stage){
            foreach ($stages as $stage2){
                if($stage->getId()!=$stage2->getId()){
                    if($stage->getEtudiant()->getId()==$stage2->getEtudiant()->getId()){
                        if($stage->getDateDebut()<=$stage2->getDateDebut()){
                            $stage1annee[] = $stage;
                        }else{
                            $stage2annee[] = $stage;
                        }
                    }
                }
            }
        }    



        $enseignants1 = $this->getDoctrine() //Admin
        ->getRepository(Enseignant::class)
        ->findByNiveau('0');

        $enseignants2 = $this->getDoctrine() // Enseignant
        ->getRepository(Enseignant::class)
        ->findByNiveau('1');

        $enseignants = $enseignants1 + $enseignants2;




        return $this->render('stage/listerPromo.html.twig', [
            'pStages1' => $stage1annee,'pStages2' => $stage2annee, 'pEnseignants' => $enseignants]);
    }

    public function newEnseignant($idStage,$idEnseignant){

        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($idStage);

        echo "";

        return $this->render('stage/listerPromo.html.twig', [
            'pStages1' => $stage1annee,'pStages2' => $stage2annee, 'pEnseignants' => $enseignants]);
    }







 public function listerSemaine($idStage){
       
                    

           // var_dump($semaineStage);

       $stage = $this->getDoctrine()->getRepository(Stage::class)->find($idStage);

       /*foreach  ($stage->getSemaineStages() as $ss ){
        var_dump ($ss);
       }*/
       // var_dump($stage);

            //var_dump($stage);

        return $this->render('stage/listerSemaine.html.twig', ['stage' => $stage]);
     } 
            
        
    //}   


/*public function listerSemaine($stage_id)
     {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($stage_id);
var_dump($stage);


         return $this->render('stage/listerSemaine.html.twig', ['stage' => $stage]);
     }*/






public function ajouterStage(Request $request){
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
 
            $stage = $form->getData();

 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();
                        return $this->render('stage/consulter.html.twig', ['pStage' => $stage,]);
        }
        else
        {
            return $this->render('stage/ajouter.html.twig', array('form' => $form->createView(),));
        }

    }
}