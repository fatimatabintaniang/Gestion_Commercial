<?php
namespace App\Core\Abstract;

abstract class AbstractController{
  protected function toJson(array $data): string {
    header('Content-Type: application/json');
    return json_encode($data);
  }
}
