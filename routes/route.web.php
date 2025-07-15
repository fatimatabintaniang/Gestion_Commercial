<?php

use App\Controller\Web\PersonneController;
use App\Controller\Web\SecurityController;

$routes = [
    "accueil" => [
        'controller' => PersonneController::class,
        'action' => "index",
    ],
    "form" => [
        'controller' => SecurityController::class,
        'action' => "form"
    ],
    "" => [
        'controller' => SecurityController::class,
        'action' => "form"
    ],
    "login" => [
        'controller' => SecurityController::class,
        'action' => "login"
    ],
    "logout" => [
        'controller' => SecurityController::class,
        'action' => "logout"
    ],
];
