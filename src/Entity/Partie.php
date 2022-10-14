<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Joueur $fk_idJoueur = null;

    #[ORM\Column]
    private ?int $nbcoups = null;

    #[ORM\Column]
    private ?int $temps = null;

    #[ORM\Column]
    private ?bool $resultat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdJoueur(): ?Joueur
    {
        return $this->fk_idJoueur;
    }

    public function setFkIdJoueur(?Joueur $fk_idJoueur): self
    {
        $this->fk_idJoueur = $fk_idJoueur;

        return $this;
    }

    public function getNbcoups(): ?int
    {
        return $this->nbcoups;
    }

    public function setNbcoups(int $nbcoups): self
    {
        $this->nbcoups = $nbcoups;

        return $this;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(int $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function isResultat(): ?bool
    {
        return $this->resultat;
    }

    public function setResultat(bool $resultat): self
    {
        $this->resultat = $resultat;

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
}
