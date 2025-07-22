<?php

namespace App\Controller\Web;

use App\Core\Abstract\AbstractController;
use App\Core\Gard;
use App\Service\CommandeService;
use App\Service\PersonneService;

class CommandeController extends AbstractController
{
    private $commandeService;
    private $personneService;
    private Gard $gard;
    public function __construct()
    {
        $this->commandeService = CommandeService::getInstance();
        $this->gard = Gard::getInstance();
        $this->personneService = PersonneService::getInstance();
    }
   public function index(): void
{
    $this->gard->authGard();
    $filters = [
        'numero' => $_GET['search'] ?? null,
        'date' => $_GET['Date_search'] ?? null,
        'client_nom' => $_GET['client_search'] ?? null
    ];
  
    // Appel unique du service
    $commandes = $this->commandeService->getAllCommandes($filters);
    $client = null;
    if (isset($_GET['tel_client'])) {
        $client = $this->personneService->getClientByTel($_GET['tel_client']);
        $openModal = true;
        // dd($client);
    }

    render_view('commande/listeCommande', 'baseLayout', [
        'commandes' => $commandes,'client' => $client,'openModal' => $openModal ?? false,
    ]);
}

    public function store(): void {}
}
