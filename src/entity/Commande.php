<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;
use DateTime;

 class Commande extends AbstractEntity{
    private int $id;
    private string $numero;
    private ?DateTime $date ;
    private float $montant;
     private Facture $facture;
     private Produit $produit;
    private Client $client;
    private $statut;


    public function __construct($id = 0, $numero = "",?DateTime $date=null,$montant=0)
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

    public function getStatut()
    {
        return $this->statut;
        }

        public function setStatut($statut)
        {
            $this->statut = $statut;
            }
    public static function toObject(array $array): self   {
        $c = new self();
        $c->setId($array['id']);
        $c->setNumero($array['numero']) ;
        $c->setMontant($array['montant'])  ;
        $c->setClient(Client::toObject($array)) ;
        $c->setStatut($array['statut']) ;
        return $c;
    }

    public  function toArray(): array {
        return [];
    }



}
