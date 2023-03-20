<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\EveningBookingType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EveningBookingController extends AbstractController
{
    #[Route(path: '/reserver/soir', name: 'app_booking_evening')]
    public function booking(Request $request, EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository): Response
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $roomAvailable = $restaurant->getMaxGuests() - $restaurant->getCurrentGuests();

        $booking = new Booking();
        $form = $this->createForm(EveningBookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $restaurant->setCurrentGuests($restaurant->getCurrentGuests() + $booking->getGuestNumber());
            $entityManager->flush();
            $this->addFlash('success', 'Réservation prise en compte !');
            //return $this->redirect('/booking/confirmation');
        }

        return $this->render('booking/evening.html.twig', [
            'form' => $form->createView(),
            'roomAvailable' => $roomAvailable,
        ]);
    }
}