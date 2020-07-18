<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $quitSmokingDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NbCigarettePerDay;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cigarette", mappedBy="user")
     */
    private $cigarettes;

    public function __construct()
    {
        $this->cigarettes = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(?string $pictureName): self
    {
        $this->pictureName = $pictureName;
        return $this;
    }

    public function getQuitSmokingDate(): ?\DateTimeInterface
    {
        return $this->quitSmokingDate;
    }

    public function setQuitSmokingDate(\DateTimeInterface $quitSmokingDate): self
    {
        $this->quitSmokingDate = $quitSmokingDate;
        return $this;
    }

    public function getNbCigarettePerDay(): ?int
    {
        return $this->NbCigarettePerDay;
    }

    public function setNbCigarettePerDay(?int $NbCigarettePerDay): self
    {
        $this->NbCigarettePerDay = $NbCigarettePerDay;
        return $this;
    }

    /**
     * @return Collection|Cigarette[]
     */
    public function getCigarettes(): Collection
    {
        return $this->cigarettes;
    }

    public function addCigarette(Cigarette $cigarette): self
    {
        if (!$this->cigarettes->contains($cigarette)) {
            $this->cigarettes[] = $cigarette;
            $cigarette->setUser($this);
        }

        return $this;
    }

    public function removeCigarette(Cigarette $cigarette): self
    {
        if ($this->cigarettes->contains($cigarette)) {
            $this->cigarettes->removeElement($cigarette);
            // set the owning side to null (unless already changed)
            if ($cigarette->getUser() === $this) {
                $cigarette->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->pictureName,
            $this->email,
            $this->password,
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->pictureName,
            $this->email,
            $this->password,
            ) = unserialize($serialized);
    }


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


}
