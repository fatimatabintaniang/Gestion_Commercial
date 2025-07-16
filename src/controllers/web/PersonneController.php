<?php

namespace App\Controller\Web;

use App\Core\Abstract\AbstractController;

class PersonneController extends AbstractController
{
    public function index(): void
    {
        require_once "../views/vendeur/index.html.php";
    }
    public function store(): void {}
}
