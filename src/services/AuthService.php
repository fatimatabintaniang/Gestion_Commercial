<?php

namespace App\Service;

use App\Core\Abstract\Singleton;
use App\Entity\Personne;
use App\Repository\PersonneRepo;

class AuthService extends Singleton
{
    private $personneRepository;

    private function __construct(){
    $this->personneRepository = PersonneRepo::getInstance();
    }
   

    public function seconnecter($login, $password):Personne{
        $personne = $this->personneRepository->getUserConnect($login, $password);
        return $personne;
    }
}