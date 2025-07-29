<?php

namespace App\Core\Abstract;
use App\Core\Abstract\Singleton;
use App\Core\Database;
use PDO;

abstract class AbstractRepository extends Singleton
{

    protected $connection;
    protected $table;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function query(?string $query = null, array $data = [], ?callable $mapper = null, $single = false): mixed
    {
        if ($query == null) {
            $query = "SELECT * FROM $this->table";
        }
        $st = $this->connection->prepare($query);
        $st->execute($data);

        if ($single) {
            $result = $st->fetch(PDO::FETCH_ASSOC);
            if (!$result) return [];
            return $mapper ? $mapper($result) : $result;
        }


        $results = $st->fetchAll(PDO::FETCH_ASSOC);
        return $mapper ? array_map($mapper, $results) : $results;
    }


    /**
 * Exécute une requête SQL avec des paramètres
 * 
 * @param string $sql La requête SQL à exécuter
 * @param array $params Les paramètres à binder
 * @return \PDOStatement Le statement exécuté
 * @throws \PDOException En cas d'erreur SQL
 */
protected function executeQuery(string $sql, array $params = []): \PDOStatement
{
    try {
        $stmt = $this->connection->prepare($sql);
        
        // Bind des paramètres
        foreach ($params as $key => $value) {
            // Déterminer le type PDO
            $type = \PDO::PARAM_STR;
            
            if (is_int($value)) {
                $type = \PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = \PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = \PDO::PARAM_NULL;
            }
            
            // Gérer les paramètres nommés (:param) ou positionnels (?)
            if (is_string($key)) {
                $stmt->bindValue(':' . $key, $value, $type);
            } else {
                $stmt->bindValue($key + 1, $value, $type);
            }
        }
        
        $stmt->execute();
        return $stmt;
    } catch (\PDOException $e) {
        error_log("Erreur SQL: " . $e->getMessage());
        error_log("Requête: " . $sql);
        error_log("Paramètres: " . print_r($params, true));
        throw new \PDOException("Erreur lors de l'exécution de la requête SQL", 0, $e);
    }
}

}
