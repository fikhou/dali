<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="reeser")
 */
class Reeser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


     /**
     * @ORM\Column(name="nombre", type="integer", nullable=false)
     * @Assert\Positive(message="Le nombre doit être positif.")
     */
    private $nombre;

    /**
     * @ORM\Column(name="nomreser", type="string", length=255, nullable=false)
     */
    private $nomreser;

   /**
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Assert\GreaterThan("today", message="La date doit être ultérieure à aujourd'hui.")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getNomreser(): ?string
    {
        return $this->nomreser;
    }

    public function setNomreser(string $nomreser): self
    {
        $this->nomreser = $nomreser;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
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
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}

