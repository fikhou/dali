<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
    /**
     * @var string
     *
     * @ORM\Column(name="nom_etab", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Le nom de l'établissement est obligatoire.")
     * @Assert\Length(max=30, maxMessage="Le nom de l'établissement ne peut pas dépasser {{ limit }} caractères.")
     */
    private $nomEtab;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", columnDefinition="ENUM('IT', 'Marketing', 'Consulting', 'Finance','Chimie','Civil','Autres')" )
     */
    private $domaine;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autre_domaine", type="string", length=255, nullable=true)
     */
    private $autreDomaine;
    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('entreprise', 'startup', 'organisme', 'institution_financière')")
     */
    private $tetab;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="L'état est obligatoire.")
     * @Assert\Length(max=1000, maxMessage="L'état ne peut pas dépasser {{ limit }} caractères.")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=30, nullable=false)
     */
    private $etat;


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
        public function getNomEtab(): ?string
    {
        return $this->nomEtab;
    }

    public function setNomEtab(string $nomEtab): static
    {
        $this->nomEtab = $nomEtab;

        return $this;
    }

    public function getDomaine(): ?string
    {
        if ($this->domaine === 'Autres') {
            return $this->autreDomaine ?? '';
        }

        return $this->domaine;
    }

    public function setDomaine(?string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getAutreDomaine(): ?string
    {
        return $this->autreDomaine;
    }

    public function setAutreDomaine(?string $autreDomaine): self
    {
        $this->autreDomaine = $autreDomaine;

        return $this;
    }
    public function getTetab(): ?string
    {
        return $this->tetab;
    }

    public function setTetab(string $tetab): static
    {
        $this->tetab = $tetab;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
    public function __construct()
    {
        // Définir "EN ATTENTE" comme valeur par défaut pour l'état
        $this->etat = "EN ATTENTE";
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

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
