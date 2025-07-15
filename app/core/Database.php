<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
  private static $instance = null;
  private $pdo;
  private function __construct() {
    $host = $_ENV['DB_HOST'];
    $db   = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASSWORD'];

    try {
      $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Erreur de connexion : " . $e->getMessage());
    }
  }

  public static function getInstance() {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getConnection() {
    return $this->pdo;
  }
}
