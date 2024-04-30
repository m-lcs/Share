<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource()]
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\OneToMany(targetEntity: Scategorie::class, mappedBy: 'categorie', orphanRemoval: true)]
    private Collection $scategories;

    public function __construct()
    {
        $this->scategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Scategorie>
     */
    public function getScategories(): Collection
    {
        return $this->scategories;
    }

    public function addScategory(Scategorie $scategory): static
    {
        if (!$this->scategories->contains($scategory)) {
            $this->scategories->add($scategory);
            $scategory->setCategorie($this);
        }

        return $this;
    }

    public function removeScategory(Scategorie $scategory): static
    {
        if ($this->scategories->removeElement($scategory)) {
            // set the owning side to null (unless already changed)
            if ($scategory->getCategorie() === $this) {
                $scategory->setCategorie(null);
            }
        }

        return $this;
    }
}
