<?php

namespace App\Core\Abstract;


abstract class Singleton
{
    protected static $instances = [];

    protected function __construct() {}

    public static function getInstance(): static
    {
        $calledClass = static::class; // Récupère le nom de la classe appelée

        if (!isset(self::$instances[$calledClass])) {
            self::$instances[$calledClass] = new static(); // Instancie la classe appelante
        }

        return self::$instances[$calledClass];
    }
}

