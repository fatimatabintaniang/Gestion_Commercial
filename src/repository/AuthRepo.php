<?php

namespace App\repository;

use App\app\core\abstract\AbstractRepository;
use App\entities\Medecin;
use App\entities\Patient;
use PDOException;

class PersonneRepository extends AbstractRepository
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "personne";
    }
    public function selectPatientByTel($tel)
    {
        $sql = "SELECT * FROM personne WHERE tel = ? AND typepersonne = 'patient'";
        echo $sql;
        die;
        $rs = parent::query($sql, [$tel], null, true);
        if ($rs) {
            if ($rs['typePersonne'] == "patient") {
                return Patient::toObject($rs);
            } elseif ($rs['typePersonne'] == "medcin") {
                return Medecin::toObject($rs);
            }
        }
        return null;
    }

    public function insertPatient($patient)
    {
        $sql = "INSERT INTO personne (nom, tel, typepersonne) VALUES (?, ?, 'patient')";
        try {
            $ps = $this->connection->prepare($sql);
            $ps->execute([$patient->getNom(), $patient->getTel()]);

            $patient->setId($this->connection->lastInsertId());
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion du patient : " . $e->getMessage();
        }
    }
}
