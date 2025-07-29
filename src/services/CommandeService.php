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
    // Générer un numéro de commande unique
    $numero = 'CMD-' . date('Ymd') . '-' . substr(uniqid(), -4);

    // Démarrer une transaction

    try {
        // 1. Créer la commande principale
        $commandeId = $this->commandeRepo->insertCommande([
            'numero' => $numero,
            'client_id' => $clientId,
            'montant_total' => $total,
            'date' => date('Y-m-d H:i:s')
        ]);

        // 2. Ajouter les produits de la commande
        foreach ($items as $produitId => $item) {
            $this->commandeRepo->insertLigneCommande([
                'commande_id' => $commandeId,
                'produit_id' => $produitId,
                'quantite' => $item['quantite'],
                'prix_unitaire' => $item['prix'],
                'montant_total' => $item['prix'] * $item['quantite']
            ]);
        }

        // Valider la transaction

        return $commandeId;
    } catch (\Exception $e) {
        // En cas d'erreur, annuler la transaction
        throw new \RuntimeException("Erreur lors de la création de la commande : " . $e->getMessage());
    }
}
}