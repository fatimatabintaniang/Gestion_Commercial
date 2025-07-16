<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use App\Entity\Vendeur;
use App\Entity\Client;
use PDOException;

class AuthRepo extends AbstractRepository
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "personne";
    }
    public function selectClientByTel($tel)
    {
        $sql = "SELECT * FROM personne WHERE tel = ? AND typepersonne = 'Client'";
        echo $sql;
        die;
        $rs = parent::query($sql, [$tel], null, true);
        if ($rs) {
            if ($rs['typePersonne'] == "Client") {
                return Client::toObject($rs);
            } elseif ($rs['typePersonne'] == "Vendeur") {
                return Vendeur::toObject($rs);
            }
        }
        return null;
    }

    public function insertClient($Client)
    {
        $sql = "INSERT INTO personne (nom, tel, typepersonne) VALUES (?, ?, 'Client')";
        try {
            $ps = $this->connection->prepare($sql);
            $ps->execute([$Client->getNom(), $Client->getTel()]);

            $Client->setId($this->connection->lastInsertId());
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion du Client : " . $e->getMessage();
        }
    }
}
