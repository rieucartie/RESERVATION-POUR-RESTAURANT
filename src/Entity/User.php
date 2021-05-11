<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface; 
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; 
/** 
* @ORM\Entity(repositoryClass="App\Repository\UserRepository") 
* @UniqueEntity( 
* fields={"email"}, 
* message="L'émail que vous avez tapé est déjà utilisé !" 
* ) 
*/ 
class User implements UserInterface 

{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255) 
     * @Assert\Length( 
     * min = 8, 
     * minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères") 
     */
    private $password;
    

    /**
     * @Assert\EqualTo(propertyPath = "password", 
     * message="Vous n'avez pas saisi le même mot de passe !" ) 
     */
    private $confirmpassword;
    
        /** 
    * @ORM\Column(type="json") 
    */ 
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="user")
     */
    private $reservation;

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

  

    
    public function getRoles(): array 
   { 
    $roles = $this->roles; 
    // garantit que chaque utilisateur possède le rôle ROLE_USER 
    // équivalent à array_push() qui ajoute un élément au tabeau 
    $roles[] = 'ROLE_RESERVER'; ; 
    //array_unique élémine des doublons 
    return array_unique($roles); 
       // return ['ROLE_USER']; 
    
    } 
    public function setRoles(array $roles): self 
    { 

    $this->roles = $roles; 
    return $this; 
    } 


    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    
    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setPassword($password) {
        $this->password = $password;
        return $this;
    }
    function getConfirmpassword() {
        return $this->confirmpassword;
    }

    function setConfirmpassword($confirmpassword) {
        $this->confirmpassword = $confirmpassword;
        return $this;
    }


    public function eraseCredentials() {
        
    }

    public function getSalt() {
        
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation[] = $reservation;
            $reservation->setUser($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservation->contains($reservation)) {
            $this->reservation->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getUser() === $this) {
                $reservation->setUser(null);
            }
        }

        return $this;
    }

    

}
