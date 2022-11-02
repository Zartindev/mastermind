<?php

namespace App\Entity;

use App\Repository\ClassementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassementRepository::class)]
class Classement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'classement', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Joueur $fk_idJoueur = null;

    #[ORM\Column]
    private ?int $nbWin = 0; // On met le nombre de win de base à 0

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdJoueur(): ?Joueur
    {
        return $this->fk_idJoueur;
    }

    public function setFkIdJoueur(Joueur $fk_idJoueur): self
    {
        $this->fk_idJoueur = $fk_idJoueur;

        return $this;
    }

    public function getNbWin(): ?int
    {
        return $this->nbWin;
    }

    public function setNbWin(int $nbWin): self
    {
        $this->nbWin = $nbWin;

        return $this;
    }
}
