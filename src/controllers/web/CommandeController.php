<?php

namespace App\Controller\Web;

use App\Core\Abstract\AbstractController;
use App\Service\CommandeService;

class CommandeController extends AbstractController
{
    private $commandeService;
    public function __construct()
    {
        $this->commandeService = CommandeService::getInstance();
    }
   public function index(): void
{
    
    $filters = [
        'numero' => $_GET['search'] ?? null,
        'date' => $_GET['Date_search'] ?? null,
        'client_nom' => $_GET['client_search'] ?? null
    ];
    // dd($filters);

    // Appel unique du service
    $commandes = $this->commandeService->getAllCommandes($filters);

    render_view('commande/listeCommande', 'baseLayout', [
        'commandes' => $commandes
    ]);
}

    public function store(): void {}
}
