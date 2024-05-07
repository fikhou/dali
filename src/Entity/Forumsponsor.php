<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumsponsorRepository")
 * @ORM\Table(name="forumsponsor")
 */
class Forumsponsor
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
    private $demande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $monatant;

    /**
     * @ORM\Column(type="integer")
     */
    private $numtel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="forumsponsors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    // Getters and setters for Forumsponsor properties

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?string
    {
        return $this->demande;
    }

    public function setDemande(string $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getMonatant(): ?int
    {
        return $this->monatant;
    }

    public function setMonatant(int $monatant): self
    {
        $this->monatant = $monatant;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

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
