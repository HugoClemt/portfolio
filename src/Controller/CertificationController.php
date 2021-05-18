<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Entity\Certification;

class CertificationController extends AbstractController
{
    /**
     * @Route("/certification", name="certification")
     */
    public function index(): Response
    {
        return $this->render('certification/index.html.twig', [
            'controller_name' => 'CertificationController',
        ]);
    }

    public function ListerCertification($etudiant_id){

        $etudiant = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($etudiant_id);

        $repository = $this->getDoctrine()->getRepository(Certification::class);
        $MesCertif = $repository->findBy(
            ['etudiant' => $etudiant_id]);
            
            return $this->render('certification/listerCertification.html.twig', [ 'pCertif' => $MesCertif, 'pEtudiant' => $etudiant]);
    }
}
