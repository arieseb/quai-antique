<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BookingHoursController extends AbstractController
{
    /**
     * @param Request $request
     * @param RestaurantRepository $restaurantRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse|void
     */
    #[Route(path: '/noon_booking_hours', name: 'noon_booking_hours')]
    public function noonBookingHours (Request $request, RestaurantRepository $restaurantRepository, SerializerInterface $serializer)
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $noonOpening = $restaurant->getNoonOpeningHour();
        $noonClosing = $restaurant->getNoonClosingHour();


        if ($request->isXmlHttpRequest()) {
            $data = [
                $noonOpening->format('H'),
                $noonClosing->format('H')
            ];
            return new JsonResponse($data);
        }
    }

    /**
     * @param Request $request
     * @param RestaurantRepository $restaurantRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse|void
     */
    #[Route(path: '/evening_booking_hours', name: 'evening_booking_hours')]
    public function eveningBookingHours (Request $request, RestaurantRepository $restaurantRepository, SerializerInterface $serializer)
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $eveningOpening = $restaurant->getEveningOpeningHour();
        $eveningClosing = $restaurant->getEveningClosingHour();


        if ($request->isXmlHttpRequest()) {
            $data = [
                $eveningOpening->format('H'),
                $eveningClosing->format('H')
            ];
            return new JsonResponse($data);
        }
    }
}