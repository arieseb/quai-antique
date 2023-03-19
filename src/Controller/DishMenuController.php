<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DishMenuController extends AbstractController
{
    #[Route(path: '/carte', name: 'app_menu')]
    public function index(CategoryRepository $categoryRepository, DishRepository $dishRepository): Response
    {
        return $this->render('menu.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'dishes' => $dishRepository->findAll(),
        ]);
    }
}