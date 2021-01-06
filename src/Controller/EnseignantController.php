<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RP;
use App\Entity\Enseignant;
use App\Entity\activite;
use App\Entity\Stage;
use Symfony\Component\HttpFoundation\Request;

class EnseignantController extends AbstractController
{
    /**
     * @Route("/enseignant", name="enseignant")
     */
    public function accueilEnseignant($enseignant_id)
    {

        $repository = $this->getDoctrine()->getRepository(RP::class);
        $RPaCommenter = $repository->findBy(
            ['enseignant' => $enseignant_id, 'statut' => 2],array('libcourt'=>'asc'));

        $stages = $this->getDoctrine()
        ->getRepository(Stage::class)
        ->findByEnseignant($enseignant_id);
        
        return $this->render('enseignant/accueil.html.twig', ['pRP' => $RPaCommenter, 'pStages' => $stages]);
    }
    }
     

