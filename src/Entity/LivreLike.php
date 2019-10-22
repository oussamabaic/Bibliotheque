<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreLikeRepository")
 * @ApiResource
 */
class LivreLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Livre", inversedBy="likes")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likes")
     */
    private $user;

    public function __toString(): string
    {
        return (string)$this->user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Livre
    {
        return $this->post;
    }

    public function setPost(?Livre $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}