<?php

namespace App\repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\Database;
use App\Core\Filter;
use App\Entity\Vendeur;
use App\Entity\Client;
use App\Entity\Commande;
use PDOException;

class CommandeRepo extends AbstractRepository
{
    private Filter $filter;

    public function __construct()
    {
        parent::__construct();
        $this->table = "commande";
        $this->filter = Filter::getInstance();
    }

public function getCommandes(array $filters = [])
{
    $sql = "SELECT c.*, p.nom, p.prenom, p.telephone, p.email
            FROM commande c
            JOIN personne p ON c.client_id = p.id
            WHERE c.deleted = 1";

    $params = [];

    if (!empty($filters['numero'])) {
        $sql .= " AND c.numero = ?";
        $params[] = (string)$filters['numero']; 
    }

        if (!empty($filters['date'])) {
            $sql .= " AND c.date = ?";
            $params[] = $filters['date'];
        }

        if (!empty($filters['client_nom'])) {
            $sql .= " AND p.nom LIKE ?";
            $params[] = '%' . $filters['client_nom'] . '%';
        }

        // Debug final
        error_log("Requête finale: " . $sql);
        error_log("Paramètres finaux: " . print_r($params, true));

    return parent::query($sql, $params, [Commande::class, "toObject"]);
}

    public function getCommandeById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";
        return parent::query($sql, [$id], null, true);
    }
}