<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private $Id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Beacon;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $QRCode;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getBeacon(): ?int
    {
        return $this->Beacon;
    }

    public function setBeacon(int $Beacon): self
    {
        $this->Beacon = $Beacon;

        return $this;
    }

    public function getQRCode(): ?string
    {
        return $this->QRCode;
    }

    public function setQRCode(string $QRCode): self
    {
        $this->QRCode = $QRCode;

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
}
