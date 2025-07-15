<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

abstract class Personne extends AbstractEntity
{
    protected $id;
    protected $nom;
     protected $prenom;
     protected $typepersonne;
     protected $email;
     protected $password;


    public function __construct($id = null, $nom = null,$prenom=null,$email=null,$password=null,$typepersonne=null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom=$prenom;
        $this->typepersonne=$typepersonne;
        $this->email=$email;
        $this->password=$password;


    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }


}
