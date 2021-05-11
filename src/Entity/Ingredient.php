<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
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
     * @ORM\ManyToMany(targetEntity=Tapas::class, mappedBy="ingredient")
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
            $tapa->addIngredient($this);
        }

        return $this;
    }

    public function removeTapa(Tapas $tapa): self
    {
        if ($this->tapas->contains($tapa)) {
            $this->tapas->removeElement($tapa);
            $tapa->removeIngredient($this);
        }

        return $this;
    }
    public function __tostring() {
           return $this->nom;

     }
}
