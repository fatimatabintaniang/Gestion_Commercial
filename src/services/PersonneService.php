<?php

namespace App\Service;

use App\Core\Abstract\Singleton;
use App\Entity\Commande;
use App\Repository\CommandeRepo;
use App\Repository\PersonneRepo;

class PersonneService extends Singleton
{
    private $commandeRepo;
    private $personne;
    public function __construct()
    {
        $this->commandeRepo = CommandeRepo::getInstance();
        $this->personne = PersonneRepo::getInstance();
    }
   

    public function getAllClients()
    {
        // Logic to retrieve all clients
        return []; // Placeholder for actual client retrieval logic
    }

    public function getClientByTel($tel){
        $client = $this->personne->findByTel($tel);
        return $client;
    }

    public function getAllVendeurs()
    {
        // Logic to retrieve all vendeurs
        return []; // Placeholder for actual vendeur retrieval logic
    }
}