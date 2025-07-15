<?php

namespace App\Core;

class Router{
    public static function resolve()
    {

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        if (str_contains($url, "api")) {
            require_once $_ENV['ROOT_PATH'] . "/routes/route.api.php";
        } else {
            require_once $_ENV['ROOT_PATH'] . "/routes/route.web.php";
        }
        if (!isset($routes[$url])) {
            // ErrorController::error404();
            exit;
        }
        $route = $routes[$url];
        //Traitement middlewares
        if (!class_exists($route["controller"]) || !method_exists($route["controller"], $route["action"])) {
            // ErrorController::error404();
        }
        $controller = new $route["controller"]();
        $controller->{$route["action"]}();
    }
}
