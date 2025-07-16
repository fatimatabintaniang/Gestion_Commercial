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
        $commandes = $this->commandeService->getAllCommandes();
        dd($commandes);
        // require_once "../views/commande/listeCommande.html.php";
        render_view('commande/listeCommande' , 'baseLayout' , ['commandes' => $commandes]); 

    }
    public function store(): void {}
}
