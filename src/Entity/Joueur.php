<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Cast\Bool_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Joueur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgProfil = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgBanniere = null;

    #[ORM\OneToOne(mappedBy: 'fk_idJoueur', cascade: ['persist', 'remove'])]
    private ?Classement $classement = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private $isActive = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImgProfil(): ?string
    {
        return $this->imgProfil;
    }

    public function setImgProfil(?string $imgProfil): self
    {
        $this->imgProfil = $imgProfil;

        return $this;
    }

    public function getImgBanniere(): ?string
    {
        return $this->imgBanniere;
    }

    public function setImgBanniere(?string $imgBanniere): self
    {
        $this->imgBanniere = $imgBanniere;

        return $this;
    }

    public function getClassement(): ?Classement
    {
        return $this->classement;
    }

    public function setClassement(Classement $classement): self
    {
        // set the owning side of the relation if necessary
        if ($classement->getFkIdJoueur() !== $this) {
            $classement->setFkIdJoueur($this);
        }

        $this->classement = $classement;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }
}
