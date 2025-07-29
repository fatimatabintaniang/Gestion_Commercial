<?php

namespace App\Service;

use App\Core\Abstract\Singleton;
use App\Repository\CommandeRepo;

class CommandeService extends Singleton
{
    private $commandeRepo;
    

    public function __construct()
    {
        $this->commandeRepo = CommandeRepo::getInstance();
    }

    public function getAllCommandes($filters = [])
    {
        return $this->commandeRepo->getCommandes($filters);
    }
    
    public function getCommandeById($id)
    {
        return $this->commandeRepo->getCommandeById($id);
    }

    public function creerCommande(int $clientId, array $items, float $total): int
{
    $numero = 'CMD-' . date('Ymd') . '-' . substr(uniqid(), -4);

    try {
        $commandeId = $this->commandeRepo->insertCommande([
            'numero' => $numero,
            'client_id' => $clientId,
            'montant' => $total,
            'date' => date('Y-m-d H:i:s')
        ]);
        foreach ($items as $produitId => $item) {
            $this->commandeRepo->insertLigneCommande([
                'commande_id' => $commandeId,
                'produit_id' => $produitId,
                'quantite' => $item['quantite'],
            ]);
        }
        return $commandeId;
    } catch (\Exception $e) {
        throw new \RuntimeException("Erreur lors de la création de la commande : " . $e->getMessage());
    }
}
}