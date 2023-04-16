<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'app_index')]
    public function index(PictureRepository $pictureRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        if (!$userRepository->findOneBy(['lastName' => 'Admin'])) {
            $newUser = new User();
            $newUser->setEmail('admin@example.com');
            $newUser->setRoles(["ROLE_ADMIN"]);
            $newUser->setFirstName('Admin');
            $newUser->setLastName('Admin');
            $newUser->setPassword('$2y$13$HpO7F6B8gUR5CSo9P32h/.OJoux3k46IeR154F7FH64WeXAKdoywG');
            $entityManager->persist($newUser);
            $entityManager->flush();
        }
        $pictures = $pictureRepository->findAll();
        return $this->render('index.html.twig', [
            'pictures' => $pictures,
        ]);
    }
}