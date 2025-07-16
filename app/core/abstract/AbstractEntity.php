<?php
namespace App\Core\Abstract;
abstract class AbstractEntity{
abstract public static function toObject(array $array): self;
 abstract public  function toArray(): array;
}