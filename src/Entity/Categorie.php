<?php

namespace App\Entity;

use App\Entity\Reservation;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Tapas::class, mappedBy="categorie")
     */
    private $tapas;

    public function __construct()
    {
        $this->tapas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Tapas[]
     */
    public function getTapas(): Collection
    {
        return $this->tapas;
    }

    public function addTapa(Tapas $tapa): self
    {
        if (!$this->tapas->contains($tapa)) {
            $this->tapas[] = $tapa;
            $tapa->setCategorie($this);
        }

        return $this;
    }

    public function removeTapa(Tapas $tapa): self
    {
        if ($this->tapas->contains($tapa)) {
            $this->tapas->removeElement($tapa);
            // set the owning side to null (unless already changed)
            if ($tapa->getCategorie() === $this) {
                $tapa->setCategorie(null);
            }
        }

        return $this;
    }
     public function __tostring() {
           return $this->nom;

     }
}
