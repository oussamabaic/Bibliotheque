<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ApiResource
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $FindateAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="events")
     */
    private $Villes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DommanderEvent", mappedBy="Events")
     */
    private $dommanderEvents;



    public function __toString(): string
    {
        return (string)$this->title;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->FindateAt = new \DateTime();
        $this->billet = new ArrayCollection();
        $this->dommanderEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getFindateAt(): ?\DateTimeInterface
    {
        return $this->FindateAt;
    }

    public function setFindateAt(\DateTimeInterface $FindateAt): self
    {
        $this->FindateAt = $FindateAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVilles(): ?Ville
    {
        return $this->Villes;
    }

    public function setVilles(?Ville $Villes): self
    {
        $this->Villes = $Villes;

        return $this;
    }

    /**
     * @return Collection|DommanderEvent[]
     */
    public function getDommanderEvents(): Collection
    {
        return $this->dommanderEvents;
    }

    public function addDommanderEvent(DommanderEvent $dommanderEvent): self
    {
        if (!$this->dommanderEvents->contains($dommanderEvent)) {
            $this->dommanderEvents[] = $dommanderEvent;
            $dommanderEvent->setEvents($this);
        }

        return $this;
    }

    public function removeDommanderEvent(DommanderEvent $dommanderEvent): self
    {
        if ($this->dommanderEvents->contains($dommanderEvent)) {
            $this->dommanderEvents->removeElement($dommanderEvent);
            // set the owning side to null (unless already changed)
            if ($dommanderEvent->getEvents() === $this) {
                $dommanderEvent->setEvents(null);
            }
        }

        return $this;
    }
}