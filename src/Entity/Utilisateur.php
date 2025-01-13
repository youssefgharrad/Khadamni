<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="ssid", columns={"ss_id"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"adresse"}, message="There is already an account with this adresse")
 */
class Utilisateur  implements UserInterface, PasswordAuthenticatedUserInterface
{
    private $userIdentifier;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    #[Assert\NotBlank(message:"name is required")]
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="num", type="integer", nullable=false)
      * @Assert\Length(
 *      min = 8,
 *      max = 8,
 *      exactMessage = "Number must be exactly {{ limit }} chiffre long"
 * )
     */
   
 
    
    private $num;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank(message = "L'adresse est obligatoire")
     * @Assert\Length(max = 50, maxMessage = "L'adresse ne peut pas dépasser {{ limit }} caractères")
     * @Assert\Email(message = "L'adresse '{{ value }}' n'est pas valide")
     
     
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false)
     * @Assert\Length(min = 8, minMessage = "votre mot de passe doit contient au moins {{ limit }} caractères")
     */
   
    private $mdp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rate", type="integer", nullable=true)
     */
    private $rate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="verified", type="boolean", nullable=true)
     */
    private $verified;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="text", length=65535, nullable=true)
     */
    private $role;

    /**
     * @var \SousServices
     *
     * @ORM\ManyToOne(targetEntity="SousServices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ss_id", referencedColumnName="Sous_service_id")
     * })
     */
    private $ss;

    /**
     * @ORM\Column(name="is_verified", type="boolean")
     */
    private $isVerified = false;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(?bool $verified): self
    {
        $this->verified = $verified;

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

    public function getSs(): ?SousServices
    {
        return $this->ss;
    }

    public function setSs(?SousServices $ss): self
    {
        $this->ss = $ss;

        return $this;
    }
//test
public function getSsName(): ?string
{
    return $this->ss ? $this->ss->getName() : null;
}

public function setSsName(?string $ssName): self
{
    if ($ssName) {
        $this->ss = new SousServices();
        $this->ss->setName($ssName);
    } else {
        $this->ss = null;
    }

    return $this;
}
public function getSalt(): ?string
    {
        return $this->nom; 
    }

    public function eraseCredentials(): void
    {
        // Erase any sensitive data on this user object
    }
    public function getUsername(): ?string
    {
        return (string)$this->adresse;
    }

    public function getUserIdentifier(): ?string
{
    return $this->adresse;
}

    public function getRoles(): array
    {
        return [$this->role];
    }
     /**
     * @return string the hashed password for this user
     */
    public function getPassword(): ?string
    {
        return $this->mdp;
    }

    public function setPassword(string $password): self
    {
        $this->mdp = $password;

        return $this;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
