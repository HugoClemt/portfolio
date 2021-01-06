<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RP;
use App\Entity\Etudiant;
use App\Entity\RPActivite; 
use App\Entity\Statut; 
use App\Form\RPType;
use App\Entity\Enseignant; 
use App\Entity\Commentaire;
use Symfony\Component\HttpFoundation\Request;

class RPController extends AbstractController
{
    /**
     * @Route("/rp", name="rp")
     */
    public function consulterRpEtudiant($rp_id){
        $rp = $this->getDoctrine()->getRepository(RP::class)->find($rp_id);

        return $this->render('rp/consulter.html.twig', ['consulter' => $rp,]);
    }

    
    public function listerLesRPEtudiant(): Response
    {
        return $this->render('rp/lister.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);                   
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
        return $this->render('rp/consulter.html.twig', [ 'consulter' => $rp,]);
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


    public function consulterCommentaireRPEtudiant($rp_id){
        $rp = $this->getDoctrine()->getRepository(Rp::class)->find($rp_id);
        return $this->render('rp/consulter_Commentaire.html.twig', ['rp' => $rp]);

        


    }


}



