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



  public function findByTel($tel){
    $sql = "SELECT * FROM personne WHERE telephone = ?";
    return parent::query($sql, [$tel], [Client::class,"toObject"], true);
  }
}
