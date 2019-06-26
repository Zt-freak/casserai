<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Room;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(
     * "today",
     * message = "WARNING: Start date should be today or after today."
     * )
     */
    private $DateStart;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $DateEnd;

    private $Length;
    private $Price;

    /**
    * @Assert\EqualTo(
    * false,
    * message = "WARNING: Temporal anomaly detected! Start date should not be after the end date!"
    * )
    */
    private $temporalAnomaly = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->Room;
    }

    public function setRoom(?Room $Room): self
    {
        $this->Room = $Room;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->DateStart;
    }

    public function setDateStart(\DateTimeInterface $DateStart): self
    {
        $this->DateStart = $DateStart;
        if ($this->DateStart > $this->DateEnd) {
            $this->temporalAnomaly = true;
        }
        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->DateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $DateEnd): self
    {
        $this->DateEnd = $DateEnd;

        return $this;
    }

    public function getLength(): ?string
    {
        $this->length = date_diff($this->DateEnd, $this->DateStart);
        return $this->length->format('%d');
    }

    public function getPrice(): ?string
    {
        $this->price = $this->length->format('%d') * 20;
        return $this->price;
    }

}
