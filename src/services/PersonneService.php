<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\CommandeRepo;

class PersonneService
{
    private $commandeRepo;

    public function __construct()
    {
        $this->commandeRepo = new CommandeRepo();
    }

    public function getAllClients()
    {
        // Logic to retrieve all clients
        return []; // Placeholder for actual client retrieval logic
    }

    public function getAllVendeurs()
    {
        // Logic to retrieve all vendeurs
        return []; // Placeholder for actual vendeur retrieval logic
    }
}