<?php

namespace App\Entity;

use DateTime;

 class Commande{
    private int $id;
    private string $numero;
    private DateTime $date;
    private float $montant;
     private Facture $facture;
     private Produit $produit;
    private Client $client;


    public function __construct($id = null, $numero = null,$date=null,$montant=null)
    {
        $this->id = $id;
        $this->numero = $numero;
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

     public function getFacture()
    {
        return $this->facture;
    }
    public function setFacture($facture)
    {
        $this->facture = $facture;
    }

      public function getProduit()
    {
        return $this->produit;
    }
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }

      public function getClient()
    {
        return $this->client;
    }
    public function setClient($client)
    {
        $this->client = $client;
    }


}
