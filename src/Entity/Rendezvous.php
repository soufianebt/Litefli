<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezvousRepository::class)
 */
class Rendezvous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $Rendezvous_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Parent_ID;

    /**
     * @ORM\Column(type="integer")
     */
    private $Centre_ID;

    /**
     * @ORM\Column(type="date")
     */
    private $RendezvousAT;

    /**
     * @ORM\Column(type="integer")
     */
    private $Medcine_ID;

    public function getId(): ?int
    {
        return $this->Rendezvous_id;
    }

    public function getParentID(): ?int
    {
        return $this->Parent_ID;
    }

    public function setParentID(int $Parent_ID): self
    {
        $this->Parent_ID = $Parent_ID;

        return $this;
    }

    public function getCentreID(): ?int
    {
        return $this->Centre_ID;
    }

    public function setCentreID(int $Centre_ID): self
    {
        $this->Centre_ID = $Centre_ID;

        return $this;
    }

    public function getRendezvousAT(): ?\DateTimeInterface
    {
        return $this->RendezvousAT;
    }

    public function setRendezvousAT(\DateTimeInterface $RendezvousAT): self
    {
        $this->RendezvousAT = $RendezvousAT;

        return $this;
    }

    public function getMedcineID(): ?int
    {
        return $this->Medcine_ID;
    }

    public function setMedcineID(int $Medcine_ID): self
    {
        $this->Medcine_ID = $Medcine_ID;

        return $this;
    }
}
