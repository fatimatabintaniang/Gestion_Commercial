<?php

namespace App\Entity;

use DateTime;

 class Facture{
    private int $id; 
    private string $numero;
    private DateTime $date;
    private float $montant;
    private Commande $commande;
    private Paiement $paiement;

    public function __construct($id=null,$numero=null,$date=null,$montant=null)
    {
        $this->id=$id;
        $this->numero=$numero;
        $this->date=$date;
        $this->montant=$montant;

    }

      public function getId()
    {
        return $this->id;
    }

        public function setId($id)
    {
        $this->id = $id;
    }

       public function getNumero()
    {
        return $this->numero;
    }

        public function setNumero($numero)
    {
        $this->numero = $numero;
    }

       public function getDate()
    {
        return $this->date;
    }

        public function setDate($date)
    {
        $this->date = $date;
    }

        public function getMontant()
    {
        return $this->montant;
    }

        public function setMontant($montant)
    {
        $this->montant = $montant;
    }

        public function getCommande()
    {
        return $this->commande;
    }

        public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    
        public function getPaiement()
    {
        return $this->paiement;
    }

        public function setPaiement($paiement)
    {
        $this->paiement = $paiement;
    }
   
}
