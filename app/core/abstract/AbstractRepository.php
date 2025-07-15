<?php
namespace App\Core\Abstract;

abstract class AbstractRepository {
  protected $db;

  public function __construct($db) {
    $this->db = $db;
  }

  protected function executeQuery($sql, $params = []) {
    // prepare + execute + return results
  }

  protected function executeUpdate($sql, $params = []) {
    // prepare + execute for insert/update/delete
  }
}
