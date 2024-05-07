<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $nomevent;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $datefin;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $image;

 
/**
 * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="events")
 * @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id", nullable=false)
 */
private $entreprise;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="event", orphanRemoval=true)
     */
    private $tickets;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="event", orphanRemoval=true)
     */
    private $reesers;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->reesers = new ArrayCollection();
    }

    // Getters and setters for Event properties

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomevent(): ?int
    {
        return $this->nomevent;
    }

    public function setNomevent(int $nomevent): self
    {
        $this->nomevent = $nomevent;
        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;
        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;
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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setEvent($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getEvent() === $this) {
                $ticket->setEvent(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Reeser[]
     */
    public function getReesers(): Collection
    {
        return $this->reesers;
    }

    public function addReeser(Reeser $reeser): self
    {
        if (!$this->reesers->contains($reeser)) {
            $this->reesers[] = $reeser;
            $reeser->setEvent($this);
        }

        return $this;
    }

    public function removeReeser(Reeser $reeser): self
    {
        if ($this->reesers->removeElement($reeser)) {
            // set the owning side to null (unless already changed)
            if ($reeser->getEvent() === $this) {
                $reeser->setEvent(null);
            }
        }

        return $this;
    }

    
}
