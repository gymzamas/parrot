<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * Rechercher les véhicules en fonction des filtres.
     *
     * @param string|null $keywords
     * @param string|null $marque
     * @param string|null $model
     * @param string|null $carburant
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @param int|null $minKilometrage
     * @param int|null $maxKilometrage
     * @param int|null $minYear
     * @param int|null $maxYear
     * @return Vehicle[]
     */
    public function findByFilters(
        ?string $keywords, 
        ?string $marque, 
        ?string $model, 
        ?string $carburant, 
        ?float $minPrice, 
        ?float $maxPrice, 
        ?int $minKilometrage, 
        ?int $maxKilometrage, 
        ?int $minYear, 
        ?int $maxYear
    ): array {
        $qb = $this->createQueryBuilder('v');

        // Filtrer par mots-clés
        if ($keywords) {
            $qb->andWhere('v.description LIKE :keywords')
               ->setParameter('keywords', '%' . $keywords . '%');
        }

        // Filtrer par marque
        if ($marque) {
            $qb->andWhere('v.marque LIKE :marque')
               ->setParameter('marque', '%' . $marque . '%');
        }

        // Filtrer par modèle
        if ($model) {
            $qb->andWhere('v.model LIKE :model')
               ->setParameter('model', '%' . $model . '%');
        }

        // Filtrer par carburant
        if ($carburant) {
            $qb->andWhere('v.carburant = :carburant')
               ->setParameter('carburant', $carburant);
        }

        // Filtrer par prix minimum
        if ($minPrice !== null) {
            $qb->andWhere('v.prix >= :minPrice')
               ->setParameter('minPrice', $minPrice);
        }

        // Filtrer par prix maximum
        if ($maxPrice !== null) {
            $qb->andWhere('v.prix <= :maxPrice')
               ->setParameter('maxPrice', $maxPrice);
        }

        // Filtrer par kilométrage minimum
        if ($minKilometrage !== null) {
            $qb->andWhere('v.kilometrage >= :minKilometrage')
               ->setParameter('minKilometrage', $minKilometrage);
        }

        // Filtrer par kilométrage maximum
        if ($maxKilometrage !== null) {
            $qb->andWhere('v.kilometrage <= :maxKilometrage')
               ->setParameter('maxKilometrage', $maxKilometrage);
        }

        // Filtrer par année minimum
        if ($minYear !== null) {
            $qb->andWhere('v.annee >= :minYear')
               ->setParameter('minYear', $minYear);
        }

        // Filtrer par année maximum
        if ($maxYear !== null) {
            $qb->andWhere('v.annee <= :maxYear')
               ->setParameter('maxYear', $maxYear);
        }

        // Retourner les résultats filtrés
        return $qb->getQuery()->getResult();
    }
}
