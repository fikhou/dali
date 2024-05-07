<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="Email", columns={"Email"})})
 * @ORM\Entity
 */
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=false)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message = "The email cannot be blank.", groups = {"registration", "login"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255, nullable=false)
     * @Assert\NotBlank(groups = {"registration", "login"})
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(groups = {"registration", "update_profile"})
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Age", type="integer", nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message = "The age cannot be blank.", groups = {"update_profile"})
     */
    private $age = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Phone", type="integer", nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message = "The phone cannot be blank.", groups = {"update_profile"})
     */
    private $phone = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message = "The address cannot be blank.", groups = {"update_profile"})
     */
    private $address = NULL;

    /**
     * @var string
     *
     * @ORM\Column(name="Role", type="string", length=255, nullable=false, options={"default"="NULL"})
     */
    private $role;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $image = NULL;

    /**
     * @var bool
     *
     * @ORM\Column(name="Status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="DatedeCreation", type="string", length=255, nullable=true)
     */
    private $datedecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="VerificationCode", type="string", length=255, nullable=true)
     */
    private $verificationcode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="user", orphanRemoval=true)
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Forumsponsor", mappedBy="user", orphanRemoval=true)
     */
    private $forumsponsors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reeser", mappedBy="user", orphanRemoval=true)
     */
    private $reesers;
    

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->forumsponsors = new ArrayCollection();
        $this->reesers = new ArrayCollection();
        $this->datedecreation = (new DateTimeImmutable())->format('Y-m-d');
        $this->verificationcode = $this->generateVerificationCode();
        $this->status = true; 
    }

    private function generateVerificationCode(): string
    {
        $length = 6; // Length of the verification code
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $verificationCode = '';
        for ($i = 0; $i < $length; $i++) {
            $verificationCode .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $verificationCode;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDatedecreation(): ?string
    {
        return $this->datedecreation;
    }

    public function setDatedecreation(string $datedecreation): self
    {
        $this->datedecreation = $datedecreation;

        return $this;
    }

    public function getVerificationcode(): ?string
    {
        return $this->verificationcode;
    }

    public function setVerificationcode(string $verificationcode): self
    {
        $this->verificationcode = $verificationcode;

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
            $ticket->setUser($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getUser() === $this) {
                $ticket->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Forumsponsor[]
     */
    public function getForumsponsors(): Collection
    {
        return $this->forumsponsors;
    }

    public function addForumsponsor(Forumsponsor $forumsponsor): self
    {
        if (!$this->forumsponsors->contains($forumsponsor)) {
            $this->forumsponsors[] = $forumsponsor;
            $forumsponsor->setUser($this);
        }

        return $this;
    }

    public function removeForumsponsor(Forumsponsor $forumsponsor): self
    {
        if ($this->forumsponsors->removeElement($forumsponsor)) {
            // set the owning side to null (unless already changed)
            if ($forumsponsor->getUser() === $this) {
                $forumsponsor->setUser(null);
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
            $reeser->setUser($this);
        }

        return $this;
    }

    public function removeReeser(Reeser $reeser): self
    {
        if ($this->reesers->removeElement($reeser)) {
            // set the owning side to null (unless already changed)
            if ($reeser->getUser() === $this) {
                $reeser->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function setRoles(array $roles): self
    {
        $this->role = $roles;

        return $this;
    }

    public function getSalt()
    {
        // Leave empty unless you are using bcrypt or another hashing method that requires a salt
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getUsername()
    {
        return $this->email;
    }


    
}
