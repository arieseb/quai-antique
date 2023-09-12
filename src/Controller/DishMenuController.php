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
    /**
     * @param CategoryRepository $categoryRepository
     * @param DishRepository $dishRepository
     * @return Response
     */
    #[Route(path: '/carte', name: 'app_menu')]
    public function index(
        CategoryRepository $categoryRepository,
        DishRepository $dishRepository,
    ): Response
    {
        return $this->render('menu.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'dishes' => $dishRepository->findAll(),
        ]);
    }

    /**
     * @param MenuRepository $menuRepository
     * @param FormulaRepository $formulaRepository
     * @return Response
     */
    #[Route(path: '/formules', name: 'app_formulas')]
    public function formulas(
        MenuRepository $menuRepository,
        FormulaRepository $formulaRepository
    ): Response
    {
        return $this->render('formulas.html.twig', [
            'menus' => $menuRepository->findAll(),
            'formulas' => $formulaRepository->findAll()
        ]);
    }
}