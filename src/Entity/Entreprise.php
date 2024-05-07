<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="entreprise")
 * @ORM\Entity
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $nomentreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="entreprise", orphanRemoval=true)
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entreprises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomentreprise(): ?string
    {
        return $this->nomentreprise;
    }

    public function setNomentreprise(string $nomentreprise): self
    {
        $this->nomentreprise = $nomentreprise;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function addUser(User $user): self
    {
        if ($this->user === null) {
            $this->user = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user === $user) {
            $this->user = null;
        }

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
