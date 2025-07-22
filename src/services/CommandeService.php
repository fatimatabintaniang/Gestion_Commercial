<?php

namespace App\Service;

use App\Core\Abstract\Singleton;
use App\Entity\Commande;
use App\Repository\CommandeRepo;

class CommandeService extends Singleton
{
    private $commandeRepo;
    

    public function __construct()
    {
        $this->commandeRepo = CommandeRepo::getInstance();
    }

    public function getAllCommandes($filters = [])
    {
        return $this->commandeRepo->getCommandes($filters);
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