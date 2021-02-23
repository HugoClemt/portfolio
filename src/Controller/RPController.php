<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RP;
use App\Entity\Etudiant;
use App\Entity\RPActivite; 
use App\Entity\Statut; 
use App\Entity\Production;
use App\Entity\Promotion;
use App\Form\RPType;
use App\Form\RPActiviteType;
use App\Form\ProductionType;
use App\Form\PromotionType;
use App\Form\SoumettreRPEnseignantType;
use App\Form\CommentaireType;
use App\Entity\Enseignant;
use App\Entity\Activite;
use App\Entity\Competence;  
use App\Entity\Commentaire;
use App\Entity\Stage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;

class RPController extends AbstractController
{

    public function listerLesRPaCommenter(Request $request)
    {

        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);
        
        return $this->render('rp/listerEnseignant.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route(name="afficherRPPromoACommenter",path="/afficherRPPromoACommenter")
     * @param Request $request
     * @return Response
     */
    public function afficherRPPromoACommenter(Request $request)
    {
        $numeroption=$_POST["numeroption"];

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById($numeroption);

        $etudiants = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findBy(array('promotion' => $promotion), array('nom' => 'ASC'));

        $rps = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findBy(array('etudiant' => $etudiants, 'statut' => 2), array('etudiant' => 'ASC'));

        $output=array();
        if ($request->isXmlHttpRequest()) {
        foreach ($rps as $rp){

            $output[]=array(
                'etu_id'=>$rp->getEtudiant()->getId(),
                'id'=>$rp->getId(),
                'nom'=>$rp->getEtudiant()->getNom(),
                'prenom'=>$rp->getEtudiant()->getPrenom(),
                'source'=>$rp->getSource()->getLibelle(),
                'libcourt'=>$rp->getLibcourt(),
                'activites'=>count($rp->getActivites()),
                'date'=>$rp->getDateDebut()->format('d/m/Y')
        );
            
        }
     /*   var_dump($themes);
        $json = json_encode($themes);

        $response = new Response();*/
        //            return $response->setContent($json);
        return new JsonResponse($output);

    }
    return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }


    public function listerLesRPaModifier($etudiant_id)
    {
        
        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaModifier = $repository->findBy(

            ['etudiant' => $etudiant_id, 'statut' => 3], array('dateModif'=>'desc'));


        return $this->render('rp/listerEtudiant.html.twig', ['pRP' => $RPaModifier]);
    }

    public function listerLesRPPromo(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);


        
        return $this->render('rp/listerRP.html.twig', array('form' => $form->createView()));
    }

    

    public function listerLesRP($etudiant_id){

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($etudiant_id);

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $MesRp = $repository->findBy(
            ['etudiant' => $etudiant_id, 'archivage' => 0], array('dateModif'=>'desc'));
            
            return $this->render('rp/listerEtudiant.html.twig', [ 'pRP' => $MesRp, 'pEtudiant' => $etudiant]);
    }

    public function listerRPArchiver($etudiant_id){

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($etudiant_id);

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $MesRp = $repository->findBy(
            ['etudiant' => $etudiant_id, 'archivage' => 1], array('dateModif'=>'desc'));
            
            return $this->render('rp/archive.html.twig', [ 'pRP' => $MesRp, 'pEtudiant' => $etudiant]);
    }

    public function ajouterRp($etudiant_id, Request $request){
        $rp = new RP();
        $form = $this->createForm(RPType::class, $rp);
        $form->handleRequest($request);
        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($etudiant_id);
        $rp->setEtudiant($etudiant);
        $statut = $this->getDoctrine()
        ->getRepository(Statut::class)
        ->find(1);
        $rp->setStatut($statut);
        $rp->setDateModif(new \DateTime('now'));
        $rp->setArchivage(0);
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->find(999);
        $rp->setEnseignant($enseignant);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $rp = $form->getData();

 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rp);
            $entityManager->flush();
            return $this->render('rp/consulter.html.twig', array('form' => $form->createView(),'pRP' => $rp, 'pEtudiant' => $etudiant));
        }
        else
        {
            return $this->render('rp/ajouter.html.twig', array('form' => $form->createView(), 'pEtudiant' => $etudiant));
        }

    }

    public function consulterActiviteRPEtudiant($rp_id){
        
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->find($rp_id);

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($rp->getEtudiant()->getId());
        
        $rpActivite = $this->getDoctrine()
        ->getRepository(RPActivite::class)
        ->findByRp($rp);

        return $this->render('rp/consulterActivite.html.twig', ['pRPActivite' => $rpActivite, 'pRP' => $rp, 'pEtudiant' => $etudiant]);
    }

    public function deleteActivite($rpActivite_id){
        $rpactivite = $this->getDoctrine()
        ->getRepository(RPActivite::class)
        ->findOneById($rpActivite_id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($rpactivite);
        $manager->flush();

        $rp = $this->getDoctrine()->getRepository(RP::class)->find($rpactivite->getRP()->getId());
        $rpActivite = $this->getDoctrine()->getRepository(RPActivite::class)->findByRp($rp);

        return $this->render('rp/consulterActivite.html.twig', ['pRPActivite' => $rpActivite, 'pRP' => $rp]);
    }

    public function ajouterActiviteRP($rp_id, Request $request){
        $activite = $this->getDoctrine()
        ->getRepository(Activite::class)
        ->findAll();
        $rpactivite = new RPActivite();
        $form = $this->createForm(RPActiviteType::class, $rpactivite);
        $form->handleRequest($request);
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->find($rp_id);
        $rpactivite->setRP($rp);
        $competences = $this->getDoctrine()
        ->getRepository(Competence::class);
        
        
 
        if ($form->isSubmitted()) {
            $rpactivite = $form->getData();
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rpactivite);
            $entityManager->flush();
            return $this->redirectToRoute('rpConsulterActivite', array( 'rp_id' => $rp->getId()));
        }
        else
        {
            return $this->render('rp/ajouterActivite.html.twig', array('form' => $form->createView(), 'pRP' => $rp, 'pCompetences' => $competences, 'pActivites' => $activite));
        }
    }

    public function consulterProductionRPEtudiant($rp_id){
        $rp = $this->getDoctrine()->getRepository(RP::class)->find($rp_id);
        $rpProduction = $this->getDoctrine()->getRepository(Production::class)->findByRp($rp);
        return $this->render('rp/consulterProduction.html.twig', ['pRPProduction' => $rpProduction, 'pRP' => $rp]);
    }

    public function ajouterProductionRP($rp_id, Request $request){
        $production = new Production();
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->find($rp_id);
        $production->setRP($rp);
 
        if ($form->isSubmitted()) {
            $production = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($production);
            $entityManager->flush();
            return $this->redirectToRoute('rpConsulterProduction', array( 'rp_id' => $rp->getId()));
        }
        else
        {
            return $this->render('rp/ajouterProduction.html.twig', array('form' => $form->createView(),));
        }
    }

    public function deleteProduction($production_id){
        $production = $this->getDoctrine()
        ->getRepository(Production::class)
        ->findOneById($production_id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($production);
        $manager->flush();

        $rp = $this->getDoctrine()->getRepository(RP::class)->find($production->getRP()->getId());
        $production = $this->getDoctrine()->getRepository(Production::class)->findByRp($rp);

        return $this->redirectToRoute('rpConsulterProduction', array( 'rp_id' => $rp->getId()));
    }

    public function modifierProduction ($production_id, Request $request)
    {
        $production = $this->getDoctrine()
        ->getRepository(Production::class)
        ->findOneById($production_id);

        $rp_id = $production->getRp()->getId();
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
    
        $form = $this->createForm(ProductionType::class, $production);
        $form->handleRequest($request);

            //var_dump($rp) ;
        if($form->isSubmitted()){
            $production = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($production);
            $entityManager->flush();
            return $this->redirectToRoute('rpConsulterProduction', array( 'rp_id' => $rp->getId()));
        }
        else{  
            return $this->render('rp/modifProduction.html.twig', array('form' => $form->createView(),'pRPProduction' => $production, 'pRP' => $rp));
        }
    }


    public function consultoModifierRP ($rp_id, Request $request)
    {
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($rp->getEtudiant()->getId());
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->find($rp->getEnseignant()->getId());
        if(!$rp){
            echo ("rp non trouvé");
            throw $this->createNotFoundException('Aucune rp trouvé avec l\'id '.$rp_id);
        }
        else
        {
            $form = $this->createForm(RPType::class, $rp);
            $form->handleRequest($request);
            $rp->setDateModif(new \DateTime('now'));

            //var_dump($rp) ;
            if($form->isSubmitted()){
                $rp = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($rp);
                $entityManager->flush();
                $this->addFlash('success', 'Réalisation modifiée avec succès !');
                return $this->render('rp/consulter.html.twig', array('form' => $form->createView(),'pRP' => $rp, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }
            else{  
                return $this->render('rp/consulter.html.twig', array('form' => $form->createView(),'pRP' => $rp, 'pEtudiant' => $etudiant, 'pEnseignant' => $enseignant));
            }

        }
    }


    public function consulterCommentaireRPEtudiant ($rp_id, Request $request)
    {
        $commentaire = new Commentaire();

        

        $formAjouter = $this->createForm(CommentaireType::class, $commentaire);
        $formAjouter->handleRequest($request);
        
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        $commentaire->setRP($rp);

        $formSoumettre = $this->createForm(SoumettreRPEnseignantType::class, $rp);
        $formSoumettre->handleRequest($request);
        
        $commentaire->setDateCommentaire(new \DateTime('now'));

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById($rp->getEnseignant()->getId(), array('nom' => 'asc'));
        $commentaire->setEnseignant($enseignant);

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaCommenter = $repository->findBy(
            ['enseignant' => $enseignant->getId(), 'statut' => 2],array('libcourt'=>'asc'));

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEnseignant($enseignant->getId());


        $statut = $this->getDoctrine()
        ->getRepository(Statut::class)
        ->findOneById(2);

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById($rp->getEnseignant()->getId());

        

        $rp->setStatut($statut);
        if($this->isGranted('ROLE_ENSEIGNANT')) {  
            if ($formAjouter->isSubmitted()) {
                $statut = $this->getDoctrine()
                ->getRepository(Statut::class)
                ->findOneById(3);

                

                $rp->setStatut($statut);
                $commentaire = $formAjouter->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commentaire);
                $entityManager->flush();
                
                return $this->render('rp/consulterCommentaire.html.twig', ['pRP' => $rp, 'formAjouter' => $formAjouter->createView()]);
            }
            else
            {
                return $this->render('rp/consulterCommentaire.html.twig', array('pRP' => $rp, 'formAjouter' => $formAjouter->createView()));
            }
        }
        else{
            if ($formSoumettre->isSubmitted()) {
                $commentaire = $formSoumettre->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commentaire);
                $entityManager->flush();
                $this->addFlash('success', 'Réalisation soumise avec succès !');
                return $this->render('rp/consulterCommentaire.html.twig', ['pRP' => $rp,'formSoumettre' => $formSoumettre->createView()]);
            }
            else
            {
                return $this->render('rp/consulterCommentaire.html.twig', array('pRP' => $rp, 'formSoumettre' => $formSoumettre->createView()));
            }
        }
    }

    public function archiveRP($rp_id, Request $request){

        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);

        $rp->setArchivage(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rp);
        $entityManager->flush();
        $this->addFlash('success', 'RP archivée avec succès !');
        #return $this->render('rp/archive.html.twig', ['pRP' => $rp]);
        return $this->redirectToRoute('etudiantListerLesRP', array( 'etudiant_id' => $rp->getEtudiant()->getId()));
    }

    public function deleteRp($rp_id){
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($rp);
        $manager->flush();
        
        #return $this->render('rp/archive.html.twig', ['pRP' => $rp]);
        return $this->redirectToRoute('rpListerArchiver', array( 'etudiant_id' => $rp->getEtudiant()->getId()));
    }

    public function restoreRP($rp_id, Request $request){

        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);

        $rp->setArchivage(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rp);
        $entityManager->flush();
        $this->addFlash('success', 'RP restorée avec succès !');
        #return $this->render('rp/listerEtudiant.html.twig', ['pRP' => $rp]);
        return $this->redirectToRoute('rpListerArchiver', array( 'etudiant_id' => $rp->getEtudiant()->getId()));
    }

    public function modifierRPActivite ($rpActivite_id, Request $request)
    {
        $rpActivite = $this->getDoctrine()
        ->getRepository(RPActivite::class)
        ->findOneById($rpActivite_id);

        $rp_id = $rpActivite->getRp()->getId();
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
    
        $form = $this->createForm(RPActiviteType::class, $rpActivite);
        $form->handleRequest($request);

            //var_dump($rp) ;
        if($form->isSubmitted()){
            $rpActivite = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rpActivite);
            $entityManager->flush();
            return $this->redirectToRoute('rpConsulterActivite', array( 'rp_id' => $rp->getId()));
        }
        else{  
            return $this->render('rp/modifActivite.html.twig', array('form' => $form->createView(),'pRPActivite' => $rpActivite, 'pRP' => $rp));
        }
    }

    public function ValiderRP($rp_id, Request $request){
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        $statut = $this->getDoctrine()
        ->getRepository(Statut::class)
        ->findOneById(4);
        $rp->setStatut($statut);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rp);
        $entityManager->flush();
        return $this->redirectToRoute('enseignantLesRPaCommenter', array( 'enseignant_id' => $rp->getEnseignant()->getId()));
        
    }

/**
     * @Route(name="afficherCompetences",path="/afficherCompetences")
     * @param Request $request
     * @return Response
     */
    public function afficherCompetences(Request $request)
    {
        $numeroption=$_POST["numeroption"];

        $activite = $this->getDoctrine()
        ->getRepository(Competence::class)
        ->findOneById($numeroption);

        $competences = $this->getDoctrine()
        ->getRepository(Competence::class)
        ->findByActivite($activite);

        $output=array();
        if ($request->isXmlHttpRequest()) {
        foreach ($competences as $competence){

            $output[]=array($competence->getLibelle());
        }
     /*   var_dump($themes);
        $json = json_encode($themes);

        $response = new Response();*/
        //            return $response->setContent($json);
        return new JsonResponse($output);

    }
    return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }


    public function deleteCommentaire($commentaire_id){
        $commentaire = $this->getDoctrine()
        ->getRepository(Commentaire::class)
        ->findOneById($commentaire_id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($commentaire);
        $manager->flush();

        $rp = $this->getDoctrine()->getRepository(RP::class)->find($commentaire->getRP()->getId());

        return $this->redirectToRoute('rpConsulterCommentaire', array( 'rp_id' => $rp->getId()));
    }

    public function modifierCommentaire ($commentaire_id, Request $request)
    {
        $commentaire = $this->getDoctrine()
        ->getRepository(Commentaire::class)
        ->findOneById($commentaire_id);

        $rp_id = $commentaire->getRp()->getId();
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
    
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

            //var_dump($rp) ;
        if($form->isSubmitted()){
            $commentaire = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('rpConsulterCommentaire', array( 'rp_id' => $rp->getId()));
        }
        else{  
            return $this->render('rp/modifCommentaire.html.twig', array('form' => $form->createView(),'pCommentaire' => $commentaire, 'pRP' => $rp));
        }
    }

    /**
     * @Route(name="afficherRPPromo",path="/afficherRPPromo")
     * @param Request $request
     * @return Response
     */
    public function afficherRPPromo(Request $request)
    {
        $numeroption=$_POST["numeroption"];

        $output=array();

        $promotion = $this->getDoctrine()
        ->getRepository(Promotion::class)
        ->findOneById($numeroption);

        $etudiants = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findBy(['promotion' => $promotion], ['nom' => 'ASC']);

        foreach ($etudiants as $etudiant){

            $rps = $this->getDoctrine()
            ->getRepository(RP::class)
            ->findBy(['etudiant' => $etudiant]);
            
            if ($request->isXmlHttpRequest()) {
            foreach ($rps as $rp){

                $output[]=array(
                    'etu_id'=>$rp->getEtudiant()->getId(),
                    'id'=>$rp->getId(),
                    'nom'=>$rp->getEtudiant()->getNom(),
                    'prenom'=>$rp->getEtudiant()->getPrenom(),
                    'source'=>$rp->getSource()->getLibelle(),
                    'libcourt'=>$rp->getLibcourt(),
                    'activites'=>count($rp->getActivites()),
                    'date'=>$rp->getDateDebut()->format('d/m/Y')
            );
                
            }
        }
    }
     /*   var_dump($themes);
        $json = json_encode($themes);

        $response = new Response();*/
        //            return $response->setContent($json);
        return new JsonResponse($output);

    
    return new JsonResponse('no results found', Response::HTTP_NOT_FOUND);
    }




    public function pdfB1($etudiant_id)
    {
        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->findOneById($etudiant_id);

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $rps = $repository->findBy(
            ['etudiant' => $etudiant->getId(), 'archivage' => 0]);

        $activites = $this->getDoctrine()
        ->getRepository(Activite::class)
        ->findByBloc(1);

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEtudiant($etudiant);



        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('rp/pdfB1.html.twig', [
            'pEtudiant' => $etudiant, 'pActivites' => $activites, "pRPs" => $rps, "pStages" => $stages
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'landscape'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

    public function rpPDF($rp_id)
    {
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);

        $repository = $this->getDoctrine()->getRepository(RPActivite::class);
        $rpActivite = $repository->findBy(
            ['rp' => $rp->getId()],array('activite'=>'asc'));

        $repository = $this->getDoctrine()->getRepository(Production::class);
        $productions = $repository->findBy(
            ['rp' => $rp->getId()],array('designation'=>'asc'));
        

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('rp/rpPDF.html.twig', [
            'pRP' => $rp, 'pRPActivite' => $rpActivite, 'pProductions' => $productions 
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




