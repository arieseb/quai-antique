<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function footer(RestaurantRepository $restaurantRepository, EntityManagerInterface $entityManager):Response
    {
        if (!$restaurantRepository->findAll()) {
            $newRestaurant = new Restaurant();
            $newRestaurant->setName('Le Quai Antique');
            $newRestaurant->setBusinessDays(["Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"]);
            $newRestaurant->setMaxGuests(32);
            $newRestaurant->setNoonOpeningHour(\DateTime::createFromFormat('H:i', '12:00'));
            $newRestaurant->setNoonClosingHour(\DateTime::createFromFormat('H:i', '15:00'));
            $newRestaurant->setEveningOpeningHour(\DateTime::createFromFormat('H:i', '19:00'));
            $newRestaurant->setEveningClosingHour(\DateTime::createFromFormat('H:i', '22:00'));
            $entityManager->persist($newRestaurant);
            $entityManager->flush();
        }
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $businessDays = implode(', ', $restaurant->getBusinessDays());
        $noonOpening = $restaurant->getNoonOpeningHour()->format('H\\Hi');
        $noonClosing = $restaurant->getNoonClosingHour()->format('H\\Hi');
        $eveningOpening = $restaurant->getEveningOpeningHour()->format('H\\Hi');
        $eveningClosing = $restaurant->getEveningClosingHour()->format('H\\Hi');

        return $this->render('footer.html.twig', [
            'businessDays' => $businessDays,
            'noonOpening' => $noonOpening,
            'noonClosing' => $noonClosing,
            'eveningOpening' => $eveningOpening,
            'eveningClosing' => $eveningClosing,
        ]);
    }
}