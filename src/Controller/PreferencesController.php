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

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route(path: '/preferences', name: 'app_preferences')]
    public function preferences(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $user = $this->token->getToken()->getUser();
            $form = $this->createForm(PreferencesType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Vos préférences ont été enregistrées');
            }

            return $this->render('preferences.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
    }
}