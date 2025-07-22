<?php

namespace App\Core;


class Router{
    public static function resolve()
    {

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $url = trim($url, '/');
        if (str_contains($url, "api")) {
            require_once ROOT_PATH . "/routes/route.api.php";
        } else {
            require_once ROOT_PATH . "/routes/route.web.php";
        }
        if (!isset($routes[$url])) {
            // ErrorController::error404();
            exit;
        }
        $route = $routes[$url];
            // dd($route);
        //Traitement middlewares
        if (!class_exists($route["controller"]) || !method_exists($route["controller"], $route["action"])) {
            // ErrorController::error404();
            echo 'Error';
        }
        if (!empty($route['gards'])) {
            require_once ROOT_PATH . "/app/config/gards.php";
            $p = new $gards['auth']();
            $p();
            // dd($gards['auth']);
            dd($p);
        }

        $controller = new $route["controller"]();

        $controller->{$route["action"]}();
    }
}
