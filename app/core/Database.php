<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection == null) {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            try {
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
                self::$connection = new PDO($dsn, $user, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
            }
        }
        return self::$connection;
    }
    private function __construct() {}
}
