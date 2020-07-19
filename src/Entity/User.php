<?php

namespace App\Entity;

use DateTimeInterface;
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
    private $nbHypotheticCigarettePerDay;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cigarette", mappedBy="user")
     */
    private $cigarettes;

    public function __construct()
    {
        $this->cigarettes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
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

    /**
     * @param array $roles
     * @return $this
     */
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

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return $this
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    /**
     * @param string|null $pictureName
     * @return $this
     */
    public function setPictureName(?string $pictureName): self
    {
        $this->pictureName = $pictureName;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getQuitSmokingDate(): ?DateTimeInterface
    {
        return $this->quitSmokingDate;
    }

    /**
     * @param DateTimeInterface $quitSmokingDate
     * @return $this
     */
    public function setQuitSmokingDate(DateTimeInterface $quitSmokingDate): self
    {
        $this->quitSmokingDate = $quitSmokingDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbHypotheticCigarettePerDay()
    {
        return $this->nbHypotheticCigarettePerDay;
    }

    /**
     * @param mixed $nbHypotheticCigarettePerDay
     * @return User
     */
    public function setNbHypotheticCigarettePerDay($nbHypotheticCigarettePerDay): self
    {
        $this->nbHypotheticCigarettePerDay = $nbHypotheticCigarettePerDay;
        return $this;
    }


    /**
     * @return Collection|Cigarette[]
     */
    public function getCigarettes(): Collection
    {
        return $this->cigarettes;
    }

    /**
     * @param Cigarette $cigarette
     * @return $this
     */
    public function addCigarette(Cigarette $cigarette): self
    {
        if (!$this->cigarettes->contains($cigarette)) {
            $this->cigarettes[] = $cigarette;
            $cigarette->setUser($this);
        }
        return $this;
    }

    /**
     * @param Cigarette $cigarette
     * @return $this
     */
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
