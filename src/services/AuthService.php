<?php

namespace App\Service;

use App\Entity\Personne;
use App\Repository\PersonneRepo;

class AuthService
{
    private static $instance = null;
    private $personneRepository;

    private function __construct(){
    $this->personneRepository = new PersonneRepo();
    }
    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function seconnecter($login, $password):Personne{
        $personne = $this->personneRepository->getUserConnect($login, $password);
        return $personne;
    }
}