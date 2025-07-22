<?php

namespace App\repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\Database;
use App\Entity\Vendeur;
use App\Entity\Client;
use App\Entity\Commande;
use PDOException;

class CommandeRepo extends AbstractRepository
{
    
    private function __construct()
    {
        parent::__construct();
        $this->table = "commande";
    }

 public function getCommandes($filters = [])
{
    $sql = "SELECT c.*, 
                   p.nom AS nom, 
                   p.prenom AS prenom, 
                   p.telephone AS telephone,
                   p.email AS email
            FROM " . $this->table . " c
            JOIN personne p ON c.client_id = p.id
            WHERE c.deleted = 'false'";
    
    $params = [];

    if (!empty($filters['numero'])) {
        $sql .= " AND c.numero = ?";
        $params[] = (string)$filters['numero']; // Conversion explicite
    }

    if (!empty($filters['date'])) {
        $sql .= " AND DATE(c.date) = ?";
        $params[] = $filters['date'];
    }

    if (!empty($filters['client_nom'])) {
        $sql .= " AND p.nom LIKE ?";
        $params[] = '%' . $filters['client_nom'] . '%';
    }

    // Debug final
    error_log("Requête finale: " . $sql);
    error_log("Paramètres finaux: " . print_r($params, true));

    return parent::query($sql, $params , [Commande::class,"toObject"]);
}

    public function getCommandeById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";
        return parent::query($sql, [$id], null, true);
    }

    public function insertCommande($commande)
    {
        $sql = "INSERT INTO " . $this->table . " (client_id, vendeur_id, date_commande) VALUES (?, ?, ?)";
        try {
            $ps = $this->connection->prepare($sql);
            $ps->execute([$commande->getClientId(), $commande->getVendeurId(), $commande->getDateCommande()]);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de la commande : " . $e->getMessage();
            return null;
        }
    }
}