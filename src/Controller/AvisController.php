<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kreait\Firebase\Factory;
use Google\Cloud\Core\Timestamp;

class AvisController extends AbstractController
{
    private $firestore;

    public function __construct(Factory $firebase)
    {
        // Utilisation de Firestore avec project_id explicite
        $this->firestore = $firebase
            ->withProjectId('garagefirebase') // Assure-toi que c'est le bon Project ID
            ->createFirestore()
            ->database();
    }

    #[Route('/avis', name: 'avis_index')]
    public function index(): Response
    {
        // Récupérer les avis depuis Firestore
        $avisCollection = $this->firestore->collection('avis')->documents();
        $avis = [];

        foreach ($avisCollection as $document) {
            $data = $document->data();

            // Convertir Timestamp en DateTime si le champ 'createdAt' existe
            if (isset($data['createdAt']) && $data['createdAt'] instanceof Timestamp) {
                $data['createdAt'] = $data['createdAt']->get()->format('Y-m-d H:i:s');
            }

            // Vérifier que les champs requis existent
            if (isset($data['nom'], $data['email'], $data['commentaire'], $data['note'], $data['createdAt'])) {
                $avis[] = $data;
            }
        }

        return $this->render('avis/index.html.twig', [
            'avis' => $avis
        ]);
    }

    #[Route('/avis/submit', name: 'avis_submit')]
    public function submit(): Response
    {
        return $this->render('avis/submit.html.twig');
    }

    #[Route('/avis/ajouter', name: 'ajouter_avis', methods: ['POST'])]
    public function ajouterAvis(Request $request): Response
    {
        // Créer un nouvel avis avec les données du formulaire
        $avisData = [
            'nom' => $request->request->get('nom'),
            'email' => $request->request->get('email'),
            'commentaire' => $request->request->get('commentaire'),
            'note' => (int)$request->request->get('note'),
            'createdAt' => new \DateTime(),
        ];

        // Sauvegarder l'avis dans Firestore
        $this->firestore->collection('avis')->add($avisData);

        // Rediriger après la soumission du formulaire
        return $this->redirectToRoute('avis_index');
    }
}
