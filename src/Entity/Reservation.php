<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @ORM\Table(name="reservations")
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
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Representation::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $representation;

    /**
     * @ORM\Column(type="smallint")
     */
    private $places;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getRepresentation(): ?Representation
    {
        return $this->representation;
    }

    public function setRepresentation(?Representation $representation): self
    {
        $this->representation = $representation;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }
}
