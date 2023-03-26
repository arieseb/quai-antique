<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function footer(RestaurantRepository $restaurantRepository):Response
    {
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