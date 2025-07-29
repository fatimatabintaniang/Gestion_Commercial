<?php

namespace App\Controller\Web;

use App\Core\Abstract\AbstractController;
use App\Core\Panier;
use App\Service\CommandeService;
use App\Service\PersonneService;
use App\Service\ProduitService;

class CommandeController extends AbstractController
{
    private CommandeService $commandeService;
    private PersonneService $personneService;
    private ProduitService $produitService;
    private Panier $panier;

    public function __construct()
    {
        $this->commandeService = CommandeService::getInstance();
        $this->produitService = ProduitService::getInstance();
        $this->personneService = PersonneService::getInstance();
        $this->panier = new Panier();
    }

    public function index(): void
    {
        $filters = $this->getFiltersFromRequest();
        $commandes = $this->commandeService->getAllCommandes($filters);

        $clientData = $this->getClientDataFromRequest();
        $produitsDisponibles = $this->produitService->getProduitsDisponibles();

        render_view('commande/listeCommande', "baseLayout", [
            'commandes' => $commandes,
            'client' => $clientData['client'],
            'openModal' => $clientData['openModal'],
            'panier' => $this->panier->getPanier(),
            'produits' => $produitsDisponibles
        ]);
    }

    public function store(): void {}

    private function getFiltersFromRequest(): array
    {
        return [
            'numero' => $_GET['search'] ?? null,
            'date' => $_GET['Date_search'] ?? null,
            'client_nom' => $_GET['client_search'] ?? null
        ];
    }

    private function getClientDataFromRequest(): array
    {
        if (!isset($_GET['tel_client'])) {
            return ['client' => null, 'openModal' => false];
        }

        return [
            'client' => $this->personneService->getClientByTel($_GET['tel_client']),
            'openModal' => true
        ];
    }

    public function ajouterProduit(): void
    {
        $produitId = (int)$_POST['produit_id'];
        $quantite = (int)$_POST['quantite'];
        $produit = $this->produitService->getProduitById($produitId);
        if ($produit) {
            $this->panier->ajouterProduit(
                $produit->getId(),
                $produit->getLibelle(),
                $produit->getPrix(),
                $quantite
            );
        }
        redirect_to("/accueil");
        exit();
    }

    public function retirerProduit(): void
    {
        $produitId = (int)$_POST['produit_id'];
        $this->panier->retirerProduit($produitId);

        redirect_to("/accueil");
        exit();
    }

    public function setClient(): void
    {
        $clientId = (int)$_POST['client_id'];
        $this->panier->setClient($clientId);

        redirect_to("/accueil");
        exit();
    }

    public function ajoutCommande(): void
    {
        
        $clientData = $this->getClientDataFromRequest();
        $produitsDisponibles = $this->produitService->getProduitsDisponibles();

        render_view('commande/ajoutCommande', "baseLayout", [
            'client' => $clientData['client'],
            'openModal' => $clientData['openModal'],
            'panier' => $this->panier->getPanier(),
            'produits' => $produitsDisponibles
        ]);
    }

    public function enregistrer(): void
{
    $panier = $this->panier->getPanier();
    
    // Vérifier qu'il y a des produits et un client
    if (empty($panier['items']) || !$panier['client_id']) {
        $_SESSION['flash_error'] = "Veuillez sélectionner un client et ajouter des produits";
        redirect_to("/accueil");
        exit();
    }

    try {
        // Enregistrer la commande via le service
        $commandeId = $this->commandeService->creerCommande(
            $panier['client_id'],
            $panier['items'],
            $panier['total']
        );

        // Vider le panier après enregistrement
        $this->panier->viderPanier();

        $_SESSION['flash_success'] = "Commande #$commandeId enregistrée avec succès";
        redirect_to("/commandes");
    } catch (\Exception $e) {
        $_SESSION['flash_error'] = "Erreur lors de l'enregistrement de la commande: " . $e->getMessage();
        redirect_to("/accueil");
    }
    exit();
}
}
