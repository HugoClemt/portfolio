<?php

namespace App\Controller;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use App\Controller\StageController;
use App\Entity\Pointage;
use App\Entity\Etudiant;
use App\Entity\Stage;
use App\Entity\TacheSemaine;
use App\Entity\SemaineStage;
use App\Entity\RPActivite;
use App\Entity\RP;
use App\Entity\Enseignant;
use App\Entity\Promotion;
use App\Entity\Matiere;
use App\Entity\User;
use App\Entity\Echange;
use App\Form\StageType;
use App\Form\AffecterType;
use App\Form\EchangeType;
use App\Form\SemaineType;
use App\Form\TacheSemaineType;
use App\Form\PointageType;
use Dompdf\Dompdf;
use Dompdf\Options;


class StageController extends AbstractController
{
     public function ListerAncienStages()
    {

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findAll();
         return $this->render('stage/listerAncien.html.twig', [
            'pStages' => $stages]);   
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
            return $this->redirectToRoute('StageConsulter', array( 'stage_id' => $stage->getId()));
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
        $semaines = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findByStage($stage->getId());
        if(!$stage){
            echo ("stage non trouvé");
            throw $this->createNotFoundException('Aucune stage trouvé avec l\'id '.$stage_id);
        }
        else
        {
            $formStage = $this->createForm(StageType::class, $stage);
            $formStage->handleRequest($request);

            $formAffecte = $this->createForm(AffecterType::class, $stage);
            $formAffecte->handleRequest($request);

            //var_dump($stage) ;
            if($formStage->isSubmitted()){
                $stage = $formStage->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($stage);
                $entityManager->flush();
                $this->addFlash('success', 'Stage modifié avec succès !');
                return $this->render('stage/consulter.html.twig', array('formStage' => $formStage->createView(), 'formAffecte' => $formAffecte->createView(), 'pSemaines' => $semaines,'pStage' => $stage, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }
            elseif($formAffecte->isSubmitted()){
                $stage = $formAffecte->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($stage);
                $entityManager->flush();
                $this->addFlash('success', 'Stage affecté avec succès !');
                return $this->render('stage/consulter.html.twig', array('formStage' => $formStage->createView(), 'formAffecte' => $formAffecte->createView(), 'pSemaines' => $semaines,'pStage' => $stage, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }
            else{  
                return $this->render('stage/consulter.html.twig', array('formStage' => $formStage->createView(), 'formAffecte' => $formAffecte->createView(), 'pSemaines' => $semaines,'pStage' => $stage, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }
        }
    }

    public function consulterSemaineStage($semaine_id, Request $request){

        $semaine = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findOneById($semaine_id);
        
        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($semaine->getStage()->getId());

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($stage->getEtudiant()->getId());

        $semaines = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findByStage($stage->getId());

        $allTaches = $this->getDoctrine()
        ->getRepository(TacheSemaine::class)
        ->findBySemaineStage($semaine_id, array('jour' => "ASC"));

        $formSemaine = $this->createForm(SemaineType::class, $semaine);
        $formSemaine->handleRequest($request);
        $semaine = $formSemaine->getData();

        $tache = new TacheSemaine();
        $formTache = $this->createForm(TacheSemaineType::class, $tache);
        $formTache->handleRequest($request);
        $semaine = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findOneById($semaine_id);
        $tache->setSemaineStage($semaine);
 
        if ($formTache->isSubmitted()) {
            $tache = $formTache->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();
            return $this->redirectToRoute('ConsulterSemaineStage', array( 'semaine_id' => $semaine->getId()));
        }
        elseif ($formSemaine->isSubmitted()){
            $semaine = $formSemaine->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($semaine);
            $entityManager->flush();
            return $this->redirectToRoute('ConsulterSemaineStage', array( 'semaine_id' => $semaine->getId()));
        }
        else
        {
            return $this->render('stage/semaine.html.twig', array('formSemaine' => $formSemaine->createView(),'pEtudiant' => $etudiant, 'formTache' => $formTache->createView(), 'pStage' => $stage, 'pSemaine' => $semaine, 'pSemaines' => $semaines, 'pTaches' => $allTaches));   
        }
    }

    public function deleteTache($tache_id){
        $tache = $this->getDoctrine()
        ->getRepository(TacheSemaine::class)
        ->findOneById($tache_id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($tache);
        $manager->flush();

        $semaine = $this->getDoctrine()->getRepository(SemaineStage::class)->find($tache->getSemaineStage()->getId());
        $tache = $this->getDoctrine()->getRepository(TacheSemaine::class)->find($semaine);

        return $this->redirectToRoute('ConsulterSemaineStage', array( 'semaine_id' => $semaine->getId()));
    }

    public function modifierTache ($tache_id, Request $request)
    {
        $tache = $this->getDoctrine()
        ->getRepository(TacheSemaine::class)
        ->findOneById($tache_id);

        $semaine_id = $tache->getSemaineStage()->getId();
        $semaine = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findOneById($semaine_id);
    
        $form = $this->createForm(TacheSemaineType::class, $tache);
        $form->handleRequest($request);

            //var_dump($rp) ;
        if($form->isSubmitted()){
            $tache = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();
            return $this->redirectToRoute('ConsulterSemaineStage', array( 'semaine_id' => $semaine->getId()));
        }
        else{  
            return $this->render('stage/modifTache.html.twig', array('form' => $form->createView()));
        }
    }

    public function pointageStage($stage_id, Request $request){

        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($stage_id);

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($stage->getEtudiant()->getId());

        $semaines = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findByStage($stage->getId());

        $pointages = $this->getDoctrine()
        ->getRepository(Pointage::class)
        ->findByStage($stage->getId());

        $pointage = new Pointage();
        $form = $this->createForm(PointageType::class, $pointage);
        $form->handleRequest($request);

        $pointage->setStage($stage);
        $pointage->setDatepoint(new \DateTime('now'));
        $pointage->setHeurepoint(new \DateTime("now"));
        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $pointage->setIp($ip);

        if($form->isSubmitted()){
            $pointage = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
            return $this->redirectToRoute('PointageStage', array('stage_id' => $stage->getId()));
        }
        else{  
            return $this->render('stage/pointage.html.twig', array('form' => $form->createView(),'pEtudiant' => $etudiant, 'pStage' => $stage, 'pSemaines' => $semaines, 'pPointages' => $pointages, 'pIp' => $ip));
        }
    }

    public function echangeStage($stage_id, Request $request){

        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($stage_id);

        $semaines = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findByStage($stage->getId());

        $echanges = $this->getDoctrine()
        ->getRepository(Echange::class)
        ->findByStage($stage->getId(), array('dateMessage' => 'DESC' ));

        $user = $this->getUser();

            foreach ($echanges as $echange){

                if (!$user->getEtudiant()){
                    if (!$echange->getUser()->getEnseignant()){
                        $echange->setLu(1);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($echange);
                        $entityManager->flush();
                    }
                }
                else{

                    foreach ($echanges as $echange){
                        if (!$echange->getUser()->getEtudiant()){
                            $echange->setLu(1);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($echange);
                            $entityManager->flush();
                        }
                        
                    }
                }
        }

        $echange = new Echange();
        $form = $this->createForm(EchangeType::class, $echange);
        $form->handleRequest($request);
        $echange->setStage($stage);
        $echange->setDateMessage(new \DateTime('now'));
        $echange->setUser($user);
        $echange->setLu(0);

        if($form->isSubmitted()){
            $echange = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($echange);
            $entityManager->flush();
            return $this->redirectToRoute('EchangeStage', array('stage_id' => $stage->getId()));
        }
        else{  
            return $this->render('stage/echange.html.twig', array('form' => $form->createView(), 'pStage' => $stage, 'pSemaines' => $semaines, 'pEchange' => $echange, 'pEchanges' => $echanges, 'pUser' => $user ));
        }
    }

    public function ListerStages(){

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findBy(array(),array('enseignant' => "DESC"));

        return $this->render('stage/listerStages.html.twig', array('pStages' => $stages));

    }

    public function pdfSemaine($semaine_id)
    {
        $semaine = $this->getDoctrine()
        ->getRepository(SemaineStage::class)
        ->findOneById($semaine_id);

        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($semaine->getStage()->getId());

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($stage->getEtudiant()->getId());

        $allTaches = $this->getDoctrine()
        ->getRepository(TacheSemaine::class)
        ->findBySemaineStage($semaine_id, array('jour' => "ASC"));

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('stage/pdfSemaine.html.twig', [
            'pEtudiant' => $etudiant, 'pTache' => $allTaches, "pStage" => $stage, "pSemaine" => $semaine
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'landscape'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

    public function pdfAttestation($stage_id)
    {

        $stage = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->find($stage_id);

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($stage->getEtudiant()->getId());

        if ( $stage->getDateDebut()->format('m') == '12' ||  $stage->getDateDebut()->format('m') == '01' || $stage->getDateDebut()->format('m') == '02' ){

            
        $repository = $this->getDoctrine()->getRepository(RP::class);
        $rps = $repository->findBy(
            ['etudiant' => $etudiant->getId(), 'source' => 7],array('libcourt'=>'asc'));
    
        }
        else{
            
        $repository = $this->getDoctrine()->getRepository(RP::class);
        $rps = $repository->findBy(
            ['etudiant' => $etudiant->getId(), 'source' => 6],array('libcourt'=>'asc'));
        
        }

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('stage/attestation.html.twig', [
            'pEtudiant' => $etudiant, "pStage" => $stage, 'pRp' => $rps
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'landscape'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

     
}