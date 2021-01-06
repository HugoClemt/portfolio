<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\SemaineStage;
use App\Entity\Etudiant;
use App\Entity\DomaineTaches;
use App\Entity\TacheSemaine;



class ActiviteController extends AbstractController
{
	
     // @Route("/activite", name="activite")
     


    public function consulterSemaine($idStage, $idSemaineStage): Response
    {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($idStage);  

        if (!$stage){
            throw $this->createNotFoundException(
                'Aucun stage trouvé avec le numéro '.$stage
            );
        }
    
        if ($idSemaineStage == 0)
        {
            $semaineStage = $stage->getSemaineStages()[0];
        }
        else
        {
            $semaineStage= $this->getDoctrine()->getRepository(SemaineStage::class)->find($idSemaineStage);
        }

        $tacheSemaine = $this -> getDoctrine()
            ->getRepository(TacheSemaine::class)
            ->findBy(
            ['semaineStage'=> $semaineStage],
            ['jour'=> 'ASC']
            );


            //echo ( $tacheSemaine->count()) ;    

           // var_dump($semaineStage);

        

            //var_dump($tacheSemaine);

        return $this->render('activite/consulterSemaine.html.twig', [
            'stage' => $stage,
            'tacheSemaine' => $tacheSemaine,
            //'numSemaine '=> $semaineStage->getNumSemaine(),
            'semaineStage'=> $semaineStage,
            
        ]);
    }

    public function listerSemaine($idStage){
       
                    

           // var_dump($semaineStage);

       $stage = $this->getDoctrine()->getRepository(Stage::class)->find($idStage);

       /*foreach  ($stage->getSemaineStages() as $ss ){
        var_dump ($ss);
       }*/
       var_dump($stage);

            //var_dump($stage);

        return $this->render('stage/listerSemaine.html.twig', ['stage' => $stage]);
     } 
            
        



    }      
