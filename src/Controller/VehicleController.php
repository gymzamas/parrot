<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicle')]
final class VehicleController extends AbstractController
{
    #[Route(name: 'app_vehicle_index', methods: ['GET'])]
    public function index(Request $request, VehicleRepository $vehicleRepository): Response
    {
        // Récupérer les filtres depuis la requête
        $keywords = $request->query->get('keywords');
        $marque = $request->query->get('marque');
        $model = $request->query->get('model');
        $carburant = $request->query->get('carburant');

        // Validation des filtres avec des valeurs par défaut
        $minPrice = filter_var($request->query->get('minPrice'), FILTER_VALIDATE_FLOAT, ["options" => ["default" => 0]]);
        $maxPrice = filter_var($request->query->get('maxPrice'), FILTER_VALIDATE_FLOAT, ["options" => ["default" => 50000]]);
        $minKilometrage = filter_var($request->query->get('minKilometrage'), FILTER_VALIDATE_INT, ["options" => ["default" => 0]]);
        $maxKilometrage = filter_var($request->query->get('maxKilometrage'), FILTER_VALIDATE_INT, ["options" => ["default" => 300000]]);
        $minYear = filter_var($request->query->get('minYear'), FILTER_VALIDATE_INT, ["options" => ["default" => 2000]]);
        $maxYear = filter_var($request->query->get('maxYear'), FILTER_VALIDATE_INT, ["options" => ["default" => date('Y')]]);

        // Construire la requête filtrée
        $vehicles = $vehicleRepository->findByFilters(
            $keywords,
            $marque,
            $model,
            $carburant,
            $minPrice,
            $maxPrice,
            $minKilometrage,
            $maxKilometrage,
            $minYear,
            $maxYear
        );

        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/new', name: 'app_vehicle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'upload d'image si nécessaire
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('vehicle_images_directory'),
                    $newFilename
                );
                $vehicle->setImage($newFilename);
            }

            $entityManager->persist($vehicle);
            $entityManager->flush();

            // Ajout d'un message flash
            $this->addFlash('success', 'Véhicule ajouté avec succès.');

            // Rediriger vers la page du nouveau véhicule
            return $this->redirectToRoute('app_vehicle_show', ['id' => $vehicle->getId()]);
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_show', methods: ['GET'])]
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }
}
