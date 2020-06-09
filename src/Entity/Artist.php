<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 * @ORM\Table(name="artists")
 */
class Artist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="artists")
     * @JoinColumn(onDelete="RESTRICT")
     */
    private $agent;

    /**
     * @ORM\OneToMany(targetEntity=Type::class, mappedBy="artist", orphanRemoval=true)
     */
    private $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection|ArtistType[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(ArtistType $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setArtist($this);
        }

        return $this;
    }

    public function removeType(ArtistType $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);

            if ($type->getArtist() === $this) {
                $type->setArtist(null);
            }
        }

        return $this;
    }
}
