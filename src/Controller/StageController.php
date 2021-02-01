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
use App\Entity\SemaineStage;
use App\Entity\RPActivite;
use App\Entity\Enseignant;
use App\Form\StageType;
use App\Form\SemaineType;
use App\Entity\Promotion;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Matiere;



class StageController extends AbstractController
{
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
            'pStages' => $stages, 'pEtudiant' => $etudiant]);
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

    public function ajouterStage($etudiant_id, Request $request){

        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($etudiant_id);
        $stage->setEtudiant($etudiant);
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById(999);
        $stage->setEnseignant($enseignant);

        if ($form->isSubmitted() && $form->isValid()) {
 
            $stage = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();

            for($i = 1; $i <= $stage->getNbsemaine(); $i++){
                $semaine = new SemaineStage();
                $formSemaine = $this->createForm(SemaineType::class, $semaine);
                $formSemaine->handleRequest($request);
                $semaine->setNumSemaine($i);
                $semaine->setStage($stage);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($semaine);
                $entityManager->flush();
            }
            return $this->render('stage/consulter.html.twig', ['pStage' => $stage, 'pEtudiant' => $etudiant, 'form' => $form->createView(),]);
        }
        else
        {
            return $this->render('stage/ajouter.html.twig', array('form' => $form->createView(), 'pEtudiant' => $etudiant));
        }
    }

    public function consultoModifierStage ($stage_id, Request $request)
    {
        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findOneById($stage_id);
        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($stage->getEtudiant()->getId());
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->find($stage->getEnseignant()->getId());
        if(!$stage){
            echo ("stage non trouvé");
            throw $this->createNotFoundException('Aucune stage trouvé avec l\'id '.$stage_id);
        }
        else
        {
            $form = $this->createForm(StageType::class, $stage);
            $form->handleRequest($request);

            //var_dump($stage) ;
            if($form->isSubmitted()){
                $stage = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($stage);
                $entityManager->flush();
                $this->addFlash('success', 'Stage modifié avec succès !');
                return $this->render('stage/consulter.html.twig', array('form' => $form->createView(),'pStage' => $stage, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }
            else{  
                return $this->render('stage/consulter.html.twig', array('form' => $form->createView(),'pStage' => $stage, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }

        }
    }
}