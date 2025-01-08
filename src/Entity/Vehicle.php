<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VehicleRepository;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $marque;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $model;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer')]
    private $kilometrage;

    #[ORM\Column(type: 'integer')]
    private $annee;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'string', length: 255, nullable: true)] // Ajout de la boîte de vitesse
    private $boiteDeVitesse;

    #[ORM\Column(type: 'string', length: 255, nullable: true)] // Ajout du type de carburant
    private $carburant;

    #[ORM\Column(type: 'date', nullable: true)] // Ajout de la date de mise en circulation
    private $dateMiseEnCirculation;

    // Getter et Setter pour l'ID
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter et Setter pour la marque
    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;
        return $this;
    }

    // Getter et Setter pour le modèle
    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;
        return $this;
    }

    // Getter et Setter pour le prix
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    // Getter et Setter pour le kilométrage
    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;
        return $this;
    }

    // Getter et Setter pour l'année
    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;
        return $this;
    }

    // Getter et Setter pour l'image
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    // Getter et Setter pour la boîte de vitesse
    public function getBoiteDeVitesse(): ?string
    {
        return $this->boiteDeVitesse;
    }

    public function setBoiteDeVitesse(?string $boiteDeVitesse): self
    {
        $this->boiteDeVitesse = $boiteDeVitesse;
        return $this;
    }

    // Getter et Setter pour le carburant
    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(?string $carburant): self
    {
        $this->carburant = $carburant;
        return $this;
    }

    // Getter et Setter pour la date de mise en circulation
    public function getDateMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->dateMiseEnCirculation;
    }

    public function setDateMiseEnCirculation(?\DateTimeInterface $dateMiseEnCirculation): self
    {
        $this->dateMiseEnCirculation = $dateMiseEnCirculation;
        return $this;
    }
}
