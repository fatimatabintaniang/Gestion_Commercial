<?php

namespace App\Service;

use App\Entity\Commande;
use App\Repository\CommandeRepo;

class CommandeService
{
    private $commandeRepo;
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
        $this->commandeRepo = CommandeRepo::getInstance();
    }

    public function getAllCommandes()
    {
        return $this->commandeRepo->getAllCommandes();
    }

    public function getCommandeById($id)
    {
        return $this->commandeRepo->getCommandeById($id);
    }

    public function createCommande(Commande $commande)
    {
        return $this->commandeRepo->insertCommande($commande);
    }
}