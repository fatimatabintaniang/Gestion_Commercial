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
            $params['c.date'] = [
                'type' => 'date',
                'value' => $filters['date']
            ];
        }

        if (!empty($filters['client_nom'])) {
            $params['p.nom'] = [
                'type' => 'like',
                'value' => $filters['client_nom']
            ];
        }

        // Application des filtres
        $result = $this->filter->apply($sql, $params);
        $sql = $result['query'];
        $params = $result['params'];

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

    public function insertCommande(array $data): int
{
    $sql = "INSERT INTO commande 
            (numero, client_id, montant, date,statut, deleted) 
            VALUES (:numero, :client_id, :montant, :date,'impaye', 1)";
    
    $this->executeQuery($sql, [
        'numero' => $data['numero'],
        'client_id' => $data['client_id'],
        'montant' => $data['montant'],
        'date' => $data['date']
    ]);

    return $this->connection->lastInsertId();
}

public function insertLigneCommande(array $data): void
{
    $sql = "INSERT INTO commande_produit 
            (commande_id, produit_id, quantite) 
            VALUES (:commande_id, :produit_id, :quantite)";
    
    $this->executeQuery($sql, [
        'commande_id' => $data['commande_id'],
        'produit_id' => $data['produit_id'],
        'quantite' => $data['quantite'],
    ]);
}
}