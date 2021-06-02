<?php

namespace App\Entity;

use App\Repository\TuteurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TuteurRepository::class)
 */
class Tuteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nomComplet;


   
    /**
     * @ORM\Column(type="string", length=40)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeCompte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomCompletBebe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="integer")
     */
    private $validation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idCentre;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(?string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    
   

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getTypeCompte(): ?string
    {
        return $this->typeCompte;
    }

    public function setTypeCompte(string $typeCompte): self
    {
        $this->typeCompte = $typeCompte;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNomCompletBebe(): ?string
    {
        return $this->nomCompletBebe;
    }

    public function setNomCompletBebe(?string $nomCompletBebe): self
    {
        $this->nomCompletBebe = $nomCompletBebe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(?int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getValidation(): ?int
    {
        return $this->validation;
    }

    public function setValidation(int $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getIdCentre(): ?int
    {
        return $this->idCentre;
    }

    public function setIdCentre(?int $idCentre): self
    {
        $this->idCentre = $idCentre;

        return $this;
    }

    
}
