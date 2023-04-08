<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use App\Repository\FormulaRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DishMenuController extends AbstractController
{
    #[Route(path: '/carte', name: 'app_menu')]
    public function index(
        CategoryRepository $categoryRepository,
        DishRepository $dishRepository,
        MenuRepository $menuRepository,
        FormulaRepository $formulaRepository
    ): Response
    {
        return $this->render('menu.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'dishes' => $dishRepository->findAll(),
            'menus' => $menuRepository->findAll(),
            'formulas' => $formulaRepository->findAll()
        ]);
    }

    #[Route(path: '/formules', name: 'app_formulas')]
    public function formulas(
        CategoryRepository $categoryRepository,
        DishRepository $dishRepository,
        MenuRepository $menuRepository,
        FormulaRepository $formulaRepository
    ): Response
    {
        return $this->render('formulas.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'dishes' => $dishRepository->findAll(),
            'menus' => $menuRepository->findAll(),
            'formulas' => $formulaRepository->findAll()
        ]);
    }
}