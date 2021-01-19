<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
     public function index(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user

        return $this->redirectToRoute('app_login', [
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

    public function admin(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/index.html.twig', ['users' => $users]);

    }
}