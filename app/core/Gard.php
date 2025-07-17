<?php

namespace App\Core;

class Gard{
    private static $instance = null;
    private Session $session;

    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->session = Session::getInstance();
    }
    public function authGard(){
        if(!$this->session->get('user') ){
            header("location: " . $_ENV['WEB_ROOT'] . "/form");
        }
    }
}