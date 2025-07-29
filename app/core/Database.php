<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                $sgbd = DB_CONNECTION;
                $host = DB_HOST;
                $port = DB_PORT;
                $dbname = DB_NAME;

                $dsn = "$sgbd:host=$host;port=$port;dbname=$dbname";

                self::$connection = new PDO($dsn, DB_USER, DB_PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Optionnel : encodage pour MySQL
                if ($sgbd === 'mysql') {
                    self::$connection->exec("SET NAMES utf8");
                }

            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    private function __construct() {}
}
