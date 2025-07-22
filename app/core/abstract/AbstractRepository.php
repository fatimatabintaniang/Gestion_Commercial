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


}
