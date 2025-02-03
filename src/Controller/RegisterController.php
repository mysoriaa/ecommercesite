<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RegisterUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
final class RegisterController extends AbstractController

{
    #[Route('/inscription', name: 'app_register')]

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {   
        $user = new User();
        $form = $this->createForm(RegisterUserType::class,$user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $user = $form->getData();
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // return $this->redirectToRoute('app_login');
        }
        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView(),
        ]);
    }
}
