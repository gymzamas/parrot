<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureOuvertureMatin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureFermetureMatin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureOuvertureApresMidi = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureFermetureApresMidi = null;

    #[ORM\Column]
    private ?bool $ferme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->Jour;
    }

    public function setJour(string $Jour): static
    {
        $this->Jour = $Jour;

        return $this;
    }

    public function getHeureOuvertureMatin(): ?\DateTimeInterface
    {
        return $this->heureOuvertureMatin;
    }

    public function setHeureOuvertureMatin(\DateTimeInterface $heureOuvertureMatin): static
    {
        $this->heureOuvertureMatin = $heureOuvertureMatin;

        return $this;
    }

    public function getHeureFermetureMatin(): ?\DateTimeInterface
    {
        return $this->heureFermetureMatin;
    }

    public function setHeureFermetureMatin(\DateTimeInterface $heureFermetureMatin): static
    {
        $this->heureFermetureMatin = $heureFermetureMatin;

        return $this;
    }

    public function getHeureOuvertureApresMidi(): ?\DateTimeInterface
    {
        return $this->heureOuvertureApresMidi;
    }

    public function setHeureOuvertureApresMidi(\DateTimeInterface $heureOuvertureApresMidi): static
    {
        $this->heureOuvertureApresMidi = $heureOuvertureApresMidi;

        return $this;
    }

    public function getHeureFermetureApresMidi(): ?\DateTimeInterface
    {
        return $this->heureFermetureApresMidi;
    }

    public function setHeureFermetureApresMidi(\DateTimeInterface $heureFermetureApresMidi): static
    {
        $this->heureFermetureApresMidi = $heureFermetureApresMidi;

        return $this;
    }

    public function isFerme(): ?bool
    {
        return $this->ferme;
    }

    public function setFerme(bool $ferme): static
    {
        $this->ferme = $ferme;

        return $this;
    }
}
