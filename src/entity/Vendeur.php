<?php

namespace App\Entity;
use App\Enum\TypePersonne;

 class Vendeur  extends Personne {
    protected $matricule; 

    public function __construct($id=null,$nom=null,$prenom=null,$matricule=null)
    {
        parent::__construct($id,$nom,$prenom,TypePersonne::VENDEUR);
        $this->matricule=$matricule;

    }

      public function getMatricule()
    {
        return $this->matricule;
    }

    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

      public function getType()
    {
        return $this->typepersonne;
    }

     public static function toObject(array $rs): self{
        $p = new self();
        $p->setId($rs['id'] ?? null);
        $p->setNom($rs['nom']);
        $p->setPrenom($rs['prenom']);
        $p->setMatricule($rs['tel']);
        return $p;
    }

       public  function toArray(): array{
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'matricule' => $this->getMatricule(),
            ];
     }


}
