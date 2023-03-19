<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Restaurant;
use App\Form\AddCategoryType;
use App\Form\AddDishType;
use App\Form\UpdateRestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route(path: '/admin', name: 'app_dashboard')]
    public function index(Request $request, EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository): Response
    {
        $category = new Category();
        $categoryForm = $this->createForm(AddCategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie créée !');
            return $this->redirect('/admin');
        }

        $dish = new Dish();
        $dishForm = $this->createForm(AddDishType::class, $dish);
        $dishForm->handleRequest($request);

        if ($dishForm->isSubmitted() && $dishForm->isValid()) {
            $entityManager->persist($dish);
            $entityManager->flush();
            $this->addFlash('success', 'Plat créé !');
            return $this->redirect('/admin');
        }

        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $restaurantForm = $this->createForm(UpdateRestaurantType::class, $restaurant);
        $restaurantForm->handleRequest($request);
        if ($restaurantForm->isSubmitted() && $restaurantForm->isValid()) {
            $restaurantRepository->save($restaurant, true);
            return $this->redirect('/admin');
        }


        return $this->render('admin/dashboard.html.twig', [
            'categoryForm' => $categoryForm->createView(),
            'dishForm' => $dishForm->createView(),
            'restaurantForm' => $restaurantForm->createView(),
        ]);
    }
}