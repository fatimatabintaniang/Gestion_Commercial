<?php

namespace App\Core;

use App\Core\Abstract\Singleton;

class Session extends Singleton
{
    

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
    }

    public function set($key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null; // Retourne null si la clé n'existe pas
    }

    public function destroy() {
        session_unset(); // Libère toutes les variables de session
        session_destroy(); // Détruit la session
    }

    public function deleteFromSession($key)
    {
        unset($_SESSION[$key]);
    }

}
