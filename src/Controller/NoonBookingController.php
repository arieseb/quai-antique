<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingDate;
use App\Form\NoonBookingType;
use App\Repository\BookingDateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;

class NoonBookingController extends AbstractController
{
    #[Route(path: '/reserver/midi', name: 'app_booking_noon')]
    public function booking(Request $request, EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository, BookingDateRepository $bookingDateRepository): Response
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $roomAvailable = $restaurant->getMaxGuests();

        $booking = new Booking();
        $form = $this->createForm(NoonBookingType::class, $booking);
        $form->handleRequest($request);
        $formDate = $form->get('date')->getData()->format('Y-m-d');
        $bookingDate = $bookingDateRepository->findOneBy(['date' => \DateTime::createFromFormat('Y-m-d', $formDate)]);
        if ($bookingDate !== null) {
            $roomAvailable = $restaurant->getMaxGuests() - $bookingDate->getNoonGuests();
            if ($form->isSubmitted() && $form->isValid()) {
                $bookingDate->setDate($booking->getDate());
                $bookingDate->setNoonGuests($bookingDate->getNoonGuests() + $booking->getGuestNumber());
                $booking->setBookingDate($bookingDate);
                $entityManager->persist($bookingDate);
                $entityManager->persist($booking);
                $entityManager->flush();
            }
        } else {
            $newBookingDate = new BookingDate();
            if ($form->isSubmitted() && $form->isValid()) {
                $newBookingDate->setDate($booking->getDate());
                $newBookingDate->setNoonGuests($booking->getGuestNumber());
                $entityManager->persist($newBookingDate);
                $booking->setBookingDate($newBookingDate);
                $entityManager->persist($booking);
                $entityManager->flush();
            }
        }

        return $this->render('booking/noon.html.twig', [
            'form' => $form->createView(),
            'roomAvailable' => $roomAvailable,
        ]);
    }
}