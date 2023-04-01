<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingDate;
use App\Form\EveningBookingType;
use App\Repository\BookingDateRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EveningBookingController extends AbstractController
{
    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    #[Route(path: '/reserver/soir', name: 'app_booking_evening')]
    public function booking(Request $request, EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository, BookingDateRepository $bookingDateRepository): Response
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $roomAvailable = $restaurant->getMaxGuests();

        if ($this->token->getToken() !== null) {
            $user = $this->token->getToken()->getUser();
        } else {
            $user = null;
        }

        $booking = new Booking();
        $form = $this->createForm(EveningBookingType::class, $booking);
        $form->handleRequest($request);
        $formDate = $form->get('date')->getData()->format('Y-m-d');
        $bookingDate = $bookingDateRepository->findOneBy(['date' => \DateTime::createFromFormat('Y-m-d', $formDate)]);
        if ($bookingDate !== null) {
            $roomAvailable = $restaurant->getMaxGuests() - $bookingDate->getEveningGuests();
            if ($form->isSubmitted() && $form->isValid()) {
                $bookingDate->setDate($booking->getDate());
                $bookingDate->setEveningGuests($bookingDate->getEveningGuests() + $booking->getGuestNumber());
                $booking->setUser($user);
                $booking->setBookingDate($bookingDate);
                $entityManager->persist($bookingDate);
                $entityManager->persist($booking);
                $entityManager->flush();
            }
        } else {
            $newBookingDate = new BookingDate();
            if ($form->isSubmitted() && $form->isValid()) {
                $newBookingDate->setDate($booking->getDate());
                $newBookingDate->setEveningGuests($booking->getGuestNumber());
                $entityManager->persist($newBookingDate);
                $booking->setUser($user);
                $booking->setBookingDate($newBookingDate);
                $entityManager->persist($booking);
                $entityManager->flush();
            }
        }

        return $this->render('booking/evening.html.twig', [
            'form' => $form->createView(),
            'roomAvailable' => $roomAvailable,
        ]);
    }
}