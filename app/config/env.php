<?php

// require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2)); 
$dotenv->load();

define('DB_CONNECTION', $_ENV['DB_CONNECTION']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_PORT', $_ENV['DB_PORT']);
define('WEB_ROOT', $_ENV['WEB_ROOT']);