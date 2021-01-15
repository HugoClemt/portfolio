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
use App\Form\RPType;
use App\Form\RPActiviteType;
use App\Form\ProductionType;
use App\Form\SoumettreRPEnseignantType;
use App\Form\CommentaireType;
use App\Entity\Enseignant;
use App\Entity\Activite; 
use App\Entity\Commentaire;
use App\Entity\Stage;
use Symfony\Component\HttpFoundation\Request;

class RPController extends AbstractController
{
    /**
     * @Route("/rp", name="rp")
     */
    public function consulterRpEtudiant($rp_id){
        $rp = $this->getDoctrine()->getRepository(RP::class)->find($rp_id);

        return $this->render('rp/consulter.html.twig', ['pRP' => $rp,]);
    }

    


    public function listerLesRPaCommenter($enseignant_id)
    {

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaCommenter = $repository->findBy(
            ['enseignant' => $enseignant_id, 'statut' => 2],array('libcourt'=>'asc'));
        
        return $this->render('rp/lister.html.twig', ['pRP' => $RPaCommenter]);
    }

    public function listerLesRPaModifier($etudiant_id)
    {

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaModifier = $repository->findBy(

            ['etudiant' => $etudiant_id, 'statut' => 3],array('libcourt'=>'asc'));


        return $this->render('rp/lister.html.twig', ['pRP' => $RPaModifier]);
    }


    // public function ajouterRp_Description(){
 
    //     $rp = new RP();
    //     $form = $this->createForm(RPType::class, $rp);
    //             return $this->render('rp/ajouter_Description.html.twig', array(
    //             'form' => $form->createView(), ));
    // }


    public function ajouterRp_Description(Request $request){
        $rp = new RP();

        $form = $this->createForm(RPType::class, $rp);
        $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) {
 
            $rp = $form->getData();

            $statut = $this->getDoctrine()
            ->getRepository(Statut::class)
            ->find(1);
            $rp->setStatut($statut);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rp);
            $entityManager->flush();
 
            //$etudiant = $rp->getEtudiant();

            //var_dump($rp->getStatut());
            return $this->render('rp/consulter.html.twig', [ 'pRP' => $rp,]);
        }
        else
            {
                //var_dump($rp);
                return $this->render('rp/ajouter_Description.html.twig', array('form' => $form->createView(),));
            }
    }

    public function listerLesRP($etudiant_id){
            
        

            $MesRp = $this->getDoctrine()
            ->getRepository(RP::class)
            ->findByEtudiant($etudiant_id);


            if (!$MesRp) {
                throw $this->createNotFoundException(
                'Aucun étudiant trouvé avec le numéro '.$etudiant_id
                );
            }
            
            return $this->render('rp/lister.html.twig', [ 'pRP' => $MesRp,]);

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
        
        if ($form->isSubmitted() && $form->isValid()) {
            $rp = $form->getData();

 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rp);
            $entityManager->flush();
                        return $this->render('rp/consulter.html.twig', array('form' => $form->createView(),'pRP' => $rp));
        }
        else
        {
            return $this->render('rp/ajouter.html.twig', array('form' => $form->createView(),));
        }

    }

    public function consulterActiviteRPEtudiant($rp_id){
        $rp = $this->getDoctrine()->getRepository(RP::class)->find($rp_id);
        $rpActivite = $this->getDoctrine()->getRepository(RPActivite::class)->findByRp($rp);

        return $this->render('rp/consulterActivite.html.twig', ['pRPActivite' => $rpActivite, 'pRP' => $rp]);
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
        
 
        if ($form->isSubmitted()) {
            $rpactivite = $form->getData();
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rpactivite);
            $entityManager->flush();
                        return $this->render('rp/consulterActivite.html.twig', ['pRPActivite' => $rpactivite, 'pRP' => $rp]);
        }
        else
        {
            return $this->render('rp/ajouterActivite.html.twig', array('form' => $form->createView(),));
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
                        return $this->render('rp/consulterProduction.html.twig', ['pRPProduction' => $production, 'pRP' => $rp]);
        }
        else
        {
            
            return $this->render('rp/ajouterProduction.html.twig', array('form' => $form->createView(),));
        }


    }


    public function modifierRP ($rp_id, Request $request)
    {
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        if(!$rp){
            echo ("rp non trouvé");
            throw $this->createNotFoundException('Aucune rp trouvé avec l\'id '.$rp_id);
        }
        else
        {
            $form = $this->createForm(RPType::class, $rp);
            $form->handleRequest($request);

            //var_dump($rp) ;
            if($form->isSubmitted()){
                $rp = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($rp);
                $entityManager->flush();
                return $this->render('rp/consulter.html.twig', array('form' => $form->createView(),'pRP' => $rp));
            }
            else{  
                return $this->render('rp/consulter.html.twig', array('form' => $form->createView(),'pRP' => $rp));
            }

        }
    }


    public function consulterCommentaireRPEtudiant ($rp_id, Request $request)
    {
        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        
        if(!$rp){
            echo ("rp non trouvé");
            throw $this->createNotFoundException('Aucune rp trouvé avec l\'id '.$rp_id);
        }
        else
        {
            $form = $this->createForm(SoumettreRPEnseignantType::class, $rp);
            $form->handleRequest($request);
            $statut = $this->getDoctrine()
            ->getRepository(Statut::class)
            ->findOneById(2);
            $rp->setStatut($statut);

            if($form->isSubmitted()){
                $rp = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($rp);
                $entityManager->flush();
                return $this->render('rp/consulterCommentaire.html.twig', array('form' => $form->createView(),'pRP' => $rp));
            }
            else{  
                return $this->render('rp/consulterCommentaire.html.twig', array('form' => $form->createView(),'pRP' => $rp));
            }

        }
    }


    public function ajouterCommentaireRP($rp_id, Request $request){
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        $rp = $this->getDoctrine()
        ->getRepository(RP::class)
        ->findOneById($rp_id);
        $commentaire->setRP($rp);

        
        $commentaire->setDateCommentaire(new \DateTime('now'));

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById($rp->getEnseignant()->getId());
        $commentaire->setEnseignant($enseignant);



        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaCommenter = $repository->findBy(
            ['enseignant' => $enseignant->getId(), 'statut' => 2],array('libcourt'=>'asc'));

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEnseignant($enseignant->getId());


        $statut = $this->getDoctrine()
        ->getRepository(Statut::class)
        ->findOneById(3);

        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findOneById(999);

        $rp->setStatut($statut);
        $rp->setEnseignant($enseignant);
        
 
        if ($form->isSubmitted()) {
            
            $commentaire = $form->getData();

 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
                        return $this->render('enseignant/accueil.html.twig', ['pRP' => $RPaCommenter, 'pStages' => $stages]);
        }
        else
        {
            
            return $this->render('rp/ajouterCommentaire.html.twig', array('form' => $form->createView(),));
        }


    }

}




