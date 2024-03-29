<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingDate;
use App\Form\NoonBookingType;
use App\Repository\BookingDateRepository;
use Doctrine\ORM\EntityManagerInterface;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NoonBookingController extends AbstractController
{
    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param RestaurantRepository $restaurantRepository
     * @param BookingDateRepository $bookingDateRepository
     * @return Response
     */
    #[Route(path: '/reserver/midi', name: 'app_booking_noon')]
    public function booking(
        Request $request,
        EntityManagerInterface $entityManager,
        RestaurantRepository $restaurantRepository,
        BookingDateRepository $bookingDateRepository,
    ): Response
    {
        $restaurant = $restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $roomAvailable = $restaurant->getMaxGuests();
        $workingDays = $restaurant->getBusinessDays();
        $locale = 'fr_FR';
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::NONE, IntlDateFormatter::NONE);
        $formatter->setPattern('EEEE');

        if ($this->token->getToken() !== null) {
            $user = $this->token->getToken()->getUser();
        } else {
            $user = null;
        }

        $booking = new Booking();
        $bookingTime = null;
        $form = $this->createForm(NoonBookingType::class, $booking);
        $form->handleRequest($request);
        $formData = $form->getData();
        $formDate = $form->get('date')->getData()->format('Y-m-d');
        $bookingDate = $bookingDateRepository->findOneBy(['date' => \DateTime::createFromFormat('Y-m-d', $formDate)]);
        if ($bookingDate !== null) {
            $roomAvailable = $restaurant->getMaxGuests() - $bookingDate->getNoonGuests();
            if ($form->isSubmitted() && $form->isValid()) {
                if (!in_array(ucfirst($formatter->format($booking->getDate())), $workingDays, true)) {
                    $this->addFlash('error', 'Le restaurant n\'est pas ouvert ce jour là');
                    return $this->render('booking/noon.html.twig', [
                        'form' => $form->createView(),
                        'roomAvailable' => $roomAvailable,
                    ]);
                }
                if (($roomAvailable - $booking->getGuestNumber()) < 0) {
                    $this->addFlash('error', 'Il n\'y a plus suffisamment de place disponible pour réserver pendant ce service');
                    return $this->render('booking/noon.html.twig', [
                        'form' => $form->createView(),
                        'roomAvailable' => $roomAvailable,
                    ]);
                }
                $bookingDate->setDate($booking->getDate());
                $bookingDate->setNoonGuests($bookingDate->getNoonGuests() + $booking->getGuestNumber());
                $booking->setUser($user);
                $booking->setBookingDate($bookingDate);
                $bookingTime = \DateTime::createFromFormat('H:i', $_POST['submit']);
                $booking->setNoonBookingTime($bookingTime);
                $entityManager->persist($bookingDate);
                $entityManager->persist($booking);
                $entityManager->flush();
                $this->addFlash('success', 'Réservation prise en compte :');
            }
        } else {
            $newBookingDate = new BookingDate();
            if ($form->isSubmitted() && $form->isValid()) {
                if (!in_array(ucfirst($formatter->format($booking->getDate())), $workingDays, true)) {
                    $this->addFlash('error', 'Le restaurant n\'est pas ouvert ce jour là');
                    return $this->render('booking/noon.html.twig', [
                        'form' => $form->createView(),
                        'roomAvailable' => $roomAvailable,
                    ]);
                }
                if (($roomAvailable - $booking->getGuestNumber()) < 0) {
                    $this->addFlash('error', 'Il n\'y a plus suffisamment de place disponible pour réserver pendant ce service');
                    return $this->render('booking/noon.html.twig', [
                        'form' => $form->createView(),
                        'roomAvailable' => $roomAvailable,
                    ]);
                }
                $newBookingDate->setDate($booking->getDate());
                $newBookingDate->setNoonGuests($booking->getGuestNumber());
                $entityManager->persist($newBookingDate);
                $booking->setUser($user);
                $booking->setBookingDate($newBookingDate);
                $bookingTime = \DateTime::createFromFormat('H:i', $_POST['submit']);
                $booking->setNoonBookingTime($bookingTime);
                $entityManager->persist($booking);
                $entityManager->flush();
                $this->addFlash('success', 'Réservation prise en compte');
            }
        }

        return $this->render('booking/noon.html.twig', [
            'form' => $form->createView(),
            'roomAvailable' => $roomAvailable,
            'formData' => $formData,
            'bookingTime' => $bookingTime,
        ]);
    }
}