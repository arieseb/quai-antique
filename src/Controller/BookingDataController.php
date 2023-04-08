<?php

namespace App\Controller;

use App\Repository\BookingDateRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BookingDataController extends AbstractController
{
    #[Route(path: '/noon_booking_data', name: 'noon_booking_data')]
    public function noonBookingData(Request $request, RestaurantRepository $restaurantRepository, BookingDateRepository $bookingDateRepository, SerializerInterface $serializer)
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $maxGuests = $restaurant->getMaxGuests();
        $data = $maxGuests;

        if($request->isXmlHttpRequest()) {
            $date = json_decode($request->getContent())->date;
            $bookingDate = $bookingDateRepository->findOneBy(['date' => \DateTime::createFromFormat('Y-m-d', $date)]);
            if ($bookingDate !== null) {
                $data = $maxGuests - $bookingDate->getNoonGuests();
            }
            $result = $serializer->serialize($data, 'json');
            return new JsonResponse($result);
        }
    }

    #[Route(path: '/evening_booking_data', name: 'evening_booking_data')]
    public function eveningBookingData(Request $request, RestaurantRepository $restaurantRepository, BookingDateRepository $bookingDateRepository, SerializerInterface $serializer)
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $maxGuests = $restaurant->getMaxGuests();
        $data = $maxGuests;

        if($request->isXmlHttpRequest()) {
            $date = json_decode($request->getContent())->date;
            $bookingDate = $bookingDateRepository->findOneBy(['date' => \DateTime::createFromFormat('Y-m-d', $date)]);
            if ($bookingDate !== null) {
                $data = $maxGuests - $bookingDate->getEveningGuests();
            }
        }
        $result = $serializer->serialize($data, 'json');
        return new JsonResponse($result);
    }
}