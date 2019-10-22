<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 * @ApiResource
 */
class Commande
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
     * @ORM\Column(type="string", length=255)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_At;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Livraison", inversedBy="commandes")
     */
    private $Livraison;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConfirmerCommande", mappedBy="Commandes")
     */
    private $confirmerCommandes;

    public function __construct()
    {
        $this->confirmerCommandes = new ArrayCollection();
    }





    public function __toString(): string
    {
        return (string)$this->Livraison;
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

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeInterface $created_At): self
    {
        $this->created_At = $created_At;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->Livraison;
    }

    public function setLivraison(?Livraison $Livraison): self
    {
        $this->Livraison = $Livraison;

        return $this;
    }

    /**
     * @return Collection|ConfirmerCommande[]
     */
    public function getConfirmerCommandes(): Collection
    {
        return $this->confirmerCommandes;
    }

    public function addConfirmerCommande(ConfirmerCommande $confirmerCommande): self
    {
        if (!$this->confirmerCommandes->contains($confirmerCommande)) {
            $this->confirmerCommandes[] = $confirmerCommande;
            $confirmerCommande->setCommandes($this);
        }

        return $this;
    }

    public function removeConfirmerCommande(ConfirmerCommande $confirmerCommande): self
    {
        if ($this->confirmerCommandes->contains($confirmerCommande)) {
            $this->confirmerCommandes->removeElement($confirmerCommande);
            // set the owning side to null (unless already changed)
            if ($confirmerCommande->getCommandes() === $this) {
                $confirmerCommande->setCommandes(null);
            }
        }

        return $this;
    }
}