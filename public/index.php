<?php

use App\Core\Router;

require_once "../vendor/autoload.php";
define("ROOT_PATH", dirname(__DIR__));
// define("WEB_ROOT", "http://localhost:8000");
require_once ROOT_PATH . "/app/config/bootstrap.php";

Router::resolve();