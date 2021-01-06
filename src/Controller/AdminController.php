<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Promotion;
use App\Form\PromotionType;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
     public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);

    }

    public function ajouterPromotion(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotion = $form->getData();
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->render('admin/listerPromotion.html.twig', ['promotion' => $promotion,]);
        }
        else
        {

            return $this->render('admin/ajouterPromotion.html.twig', array('form' => $form->createView(), ));
        }
    }

}