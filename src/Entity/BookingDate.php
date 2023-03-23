<?php

namespace App\Entity;

use App\Repository\BookingDateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingDateRepository::class)]
class BookingDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $noonGuests = 0;

    #[ORM\Column]
    private ?int $eveningGuests = 0;

    #[ORM\OneToMany(mappedBy: 'bookingDate', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNoonGuests(): ?int
    {
        return $this->noonGuests;
    }

    public function setNoonGuests(int $noonGuests): self
    {
        $this->noonGuests = $noonGuests;

        return $this;
    }

    public function getEveningGuests(): ?int
    {
        return $this->eveningGuests;
    }

    public function setEveningGuests(int $eveningGuests): self
    {
        $this->eveningGuests = $eveningGuests;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setBookingDate($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getBookingDate() === $this) {
                $booking->setBookingDate(null);
            }
        }

        return $this;
    }
}
