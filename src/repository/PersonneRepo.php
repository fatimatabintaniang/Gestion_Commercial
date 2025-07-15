<?php

namespace App\repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\Database;
use App\Entity\Vendeur;
use App\Entity\Client;
use PDOException;

class PersonneRepo extends AbstractRepository
{

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->table = "personne";
    }
    // public function selectPatientByTel($tel)
    // {
    //     $sql = "SELECT * FROM personne WHERE telephone = ? AND typepersonne = 'Vendeur'";

    //     $rs = parent::query($sql, [$tel], null, true);
    //     if ($rs) {
    //         if ($rs['typePersonne'] == "Vendeur") {
    //             return Vendeur::toObject($rs);
    //         } elseif ($rs['typePersonne'] == "Client") {
    //             return Client::toObject($rs);
    //         }
    //     }
    //     return null;
    // }

    public function getUserConnect($email, $password)
    {
        $sql = "SELECT * FROM personne WHERE email = ? AND password = ?";
        $rs = parent::query($sql, [$email, $password], null, true);
        if ($rs) {
            if ($rs['role'] == "Vendeur") {
                return Vendeur::toObject($rs);
            } elseif ($rs['role'] == "Client") {
                return Client::toObject($rs);
            }
        }
        return null;
    }



    // public function insertPatient($patient)
    // {
    //     $sql = "INSERT INTO personne (nom, tel, typepersonne) VALUES (?, ?, 'patient')";
    //     try {
    //         $ps = $this->connection->prepare($sql);
    //         $ps->execute([$patient->getNom(), $patient->getTel()]);

    //         $patient->setId($this->connection->lastInsertId());
    //     } catch (PDOException $e) {
    //         echo "Erreur lors de l'insertion du patient : " . $e->getMessage();
    //     }
    // }
}
