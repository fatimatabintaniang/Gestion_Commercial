<?php

namespace App\Controller\Web;

use App\Core\Session;
use App\Core\Validator;
use App\Service\AuthService;

class SecurityController
{
    private AuthService $authService;
    private Validator $validator;
    private Session $session;
    public function __construct()
    {
        $this->authService = AuthService::getInstance();
        $this->validator = Validator::getInstance();
        $this->session = Session::getInstance();
    }
    public function login(): void
    {
        $this->session->deleteFromSession('errors'); // Nettoyer les erreurs précédentes
        $this->session->deleteFromSession('old');

        extract($_POST);

        $result = $this->validator->validate([
            'email' => $email ?? '',
            'password' => $password ?? ''
        ], [
            'email' => [
                'required' => "L'email est obligatoire",
                'email' => "L'email n'est pas valide"
            ],
            'password' => [
                'required' => "Le mot de passe est obligatoire",
                'min:6' => "Le mot de passe doit contenir au moins 6 caractères"
            ]
        ]);

        if ($result) {
            $user = $this->authService->seconnecter($email, $password);
            if ($user !== null) {
                $this->session->set("user", $user);
                header("location: " . $_ENV['WEB_ROOT'] . "/accueil");
                exit;
            }
            $this->validator->addError("connexion", "Login ou mot de passe incorrect");
        }

        // Stocker les erreurs et les données
        $this->session->set("errors", $this->validator->getErrors());
        $this->session->set('old', $_POST);
        header("location: " . $_ENV['WEB_ROOT'] . "/form");
        exit;
    }

    public function form(): void
    {
        require_once ROOT_PATH . "/views/security/login.html.php";
        $this->session->deleteFromSession('errors');
        $this->session->deleteFromSession('old');
    }
    public function logout(): void {}
}
