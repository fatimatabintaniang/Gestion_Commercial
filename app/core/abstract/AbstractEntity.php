<?php
namespace App\Core\Abstract;
abstract class AbstractEntity{
abstract public function toObject(): static;
  abstract public function toArray(): array;
}