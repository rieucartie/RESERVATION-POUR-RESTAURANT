<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
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
     * @ORM\Column(type="datetime")
     */
    private $datereservation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombrepersonnes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $accepte;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservation")
     */
    private $user;
    
    function getId() {
        return $this->id;
    }
    function getDatereservation() {
        return $this->datereservation;
    }

    function getNombrepersonnes() {
        return $this->nombrepersonnes;
    }

    function setDatereservation($datereservation) {
        $this->datereservation = $datereservation;
        return $this;
    }

    function setNombrepersonnes($nombrepersonnes) {
        $this->nombrepersonnes = $nombrepersonnes;
        return $this;
    }

      
    function getObservation() {
        return $this->observation;
    }

    function getAccepte() {
        return $this->accepte;
    }

    function getUser() {
        return $this->user;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

   
    function setObservation($observation) {
        $this->observation = $observation;
        return $this;
    }

    function setAccepte($accepte) {
        $this->accepte = $accepte;
        return $this;
    }

    function setUser(?User $user) {
        $this->user = $user;
        return $this;
    }



  
}
