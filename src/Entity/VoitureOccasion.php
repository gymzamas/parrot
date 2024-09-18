<?php

namespace App\Entity;

use App\Repository\VoitureOccasionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureOccasionRepository::class)]
class VoitureOccasion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $anneeMiseEnCirculation = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePrincipale = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $galerieImages = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $equipementsOptions = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAnneeMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->anneeMiseEnCirculation;
    }

    public function setAnneeMiseEnCirculation(\DateTimeInterface $anneeMiseEnCirculation): static
    {
        $this->anneeMiseEnCirculation = $anneeMiseEnCirculation;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

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

    public function getImagePrincipale(): ?string
    {
        return $this->imagePrincipale;
    }

    public function setImagePrincipale(string $imagePrincipale): static
    {
        $this->imagePrincipale = $imagePrincipale;

        return $this;
    }

    public function getGalerieImages(): array
    {
        return $this->galerieImages;
    }

    public function setGalerieImages(array $galerieImages): static
    {
        $this->galerieImages = $galerieImages;

        return $this;
    }

    public function getEquipementsOptions(): array
    {
        return $this->equipementsOptions;
    }

    public function setEquipementsOptions(array $equipementsOptions): static
    {
        $this->equipementsOptions = $equipementsOptions;

        return $this;
    }
}
