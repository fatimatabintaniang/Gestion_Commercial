<?php

namespace App\Entity;

use App\Enum\TypePersonne;

 class Client  extends Personne {
    protected $telephone; 

    public function __construct($id=null,$nom=null,$prenom=null,$telephone=null)
    {
        parent::__construct($id,$nom,$prenom,TypePersonne::CLIENT);
        $this->telephone=$telephone;

    }

      public function getTelephone()
    {
        return $this->telephone;
    }

        public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

      public function getType()
    {
        return $this->typepersonne;
    }

     public  function toArray(): array{
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'telephone' => $this->getTelephone(),
            ];
     }
        public static function toObject(array $rs): self{
        $p = new self();
        $p->setId($rs['id'] ?? null);
        $p->setNom($rs['nom']);
        $p->setPrenom($rs['prenom']);
        $p->setEmail($rs['email']);
        $p->setTelephone($rs['telephone']);
        return $p;
    }
}
