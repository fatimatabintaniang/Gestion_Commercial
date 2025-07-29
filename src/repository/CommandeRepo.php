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

    $filterMap = [
        'numero' => [
            'condition' => ' AND c.numero = ?',
            'transform' => fn($v) => (string)$v,
        ],
        'date' => [
            'condition' => ' AND DATE(c.date) = ?',
            'transform' => fn($v) => $v,
        ],
        'client_nom' => [
            'condition' => ' AND LOWER(p.nom) LIKE LOWER(?)',
            'transform' => fn($v) => '%' . trim($v) . '%',
        ],
    ];

    foreach ($filterMap as $key => $config) {
        if (!empty($filters[$key])) {
            $sql .= $config['condition'];
            $params[] = $config['transform']($filters[$key]);
        }
    }

    // Debug
    error_log("Requête SQL: " . $sql);
    error_log("Paramètres: " . print_r($params, true));

    return parent::query($sql, $params, [Commande::class, "toObject"]);
}

}