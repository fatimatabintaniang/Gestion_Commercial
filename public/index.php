<?php

use App\Core\Router;

require_once "../vendor/autoload.php";
define("ROOT_PATH", dirname(__DIR__));
require_once ROOT_PATH . "/app/config/bootstrap.php";

Router::resolve();