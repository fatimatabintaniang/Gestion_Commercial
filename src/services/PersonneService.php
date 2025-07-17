<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\CommandeRepo;
use App\Repository\PersonneRepo;

class PersonneService
{
    private $commandeRepo;
    private $personne;
    private static $instance = null;
    private function __construct()
    {
        $this->commandeRepo = CommandeRepo::getInstance();
        $this->personne = PersonneRepo::getInstance();
    }
    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new self();
            }
            return self::$instance;
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