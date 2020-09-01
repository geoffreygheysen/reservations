<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Show::class, mappedBy="category")
     */
    private $show_category;

    public function __construct()
    {
        $this->show_category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Show[]
     */
    public function getShowCategory(): Collection
    {
        return $this->show_category;
    }

    public function addShowCategory(Show $showCategory): self
    {
        if (!$this->show_category->contains($showCategory)) {
            $this->show_category[] = $showCategory;
            $showCategory->setCategory($this);
        }

        return $this;
    }

    public function removeShowCategory(Show $showCategory): self
    {
        if ($this->show_category->contains($showCategory)) {
            $this->show_category->removeElement($showCategory);
            // set the owning side to null (unless already changed)
            if ($showCategory->getCategory() === $this) {
                $showCategory->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->category;
    }
}
