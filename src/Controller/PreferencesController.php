<?php

namespace App\Controller;

use App\Form\PreferencesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PreferencesController extends AbstractController
{
    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    #[Route(path: '/preferences', name: 'app_preferences')]
    public function preferences(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->token->getToken()->getUser();
        $form = $this->createForm(PreferencesType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('preferences.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}