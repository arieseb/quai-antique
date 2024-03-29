<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $passwordHasher
     * @param ValidatorInterface $validator
     * @param TokenStorageInterface $storage
     * @return Response
     */
    #[Route(path: '/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        TokenStorageInterface $storage,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        $errors = $validator->validate($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $confirmation = $form->get('passwordConfirm')->getData();
            if($password !== $confirmation) {
                $this->addFlash('error', 'Les saisies du mot de passe ne correspondent pas.');
                return $this->render('security/register.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errors
                ]);
            }
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $entityManager->persist($user);
            $entityManager->flush();
            $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
            $storage->setToken($token);
            return $this->redirectToRoute('app_index');
        }

        return $this->render('security/register.html.twig', [
           'form' => $form->createView(),
           'errors' => $errors
        ]);
    }
}