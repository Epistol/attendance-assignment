<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="Location")
     */
    private $events;


    public function __construct()
    {
        $this->events = new ArrayCollection();

    }



    public function getId()
    {
        return $this->id;
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

    public function setQRCode(?string $QRCode): self
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

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setLocation($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getLocation() === $this) {
                $event->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function __toString() {
        return $this->getId();
    }




}
