<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 * @ORM\Table(name="types")
 */
class Type
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ArtistType::class, mappedBy="type", orphanRemoval=true)
     */
    private $artists;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|ArtistType[]
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(ArtistType $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists[] = $artist;
            $artist->addType($this);
        }

        return $this;
    }

    public function removeArtist(ArtistType $artist): self
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);

            if ($artist->getType() === $this) {
                $artist->setType(null);
            }
            
        }

        return $this;
    }
}
