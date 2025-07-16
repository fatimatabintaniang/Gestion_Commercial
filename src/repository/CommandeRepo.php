<?php

namespace App\repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\Database;
use App\Entity\Vendeur;
use App\Entity\Client;
use PDOException;

class CommandeRepo extends AbstractRepository
{
    private static $instance = null;

    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct()
    {
        parent::__construct();
        $this->table = "commande";
    }

    public function getAllCommandes()
    {
        $sql = "SELECT * FROM " . $this->table;
        return parent::query($sql, [], null, false);
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