<?php

use App\Controller\Web\CommandeController;
use App\Controller\Web\SecurityController;
use App\Core\Router;

Router::addRoute(
    "accueil", 
    CommandeController::class, 
    "index", 
    ["auth"]
);

Router::addRoute(
    "form", 
    SecurityController::class, 
    "form"
);

Router::addRoute(
    "", 
    SecurityController::class, 
    "form"
);

Router::addRoute(
    "login", 
    SecurityController::class, 
    "login"
);

Router::addRoute(
    "logout", 
    SecurityController::class, 
    "logout", 
    ["auth"] 
);

Router::addRoute(
    "nouvelle",
    CommandeController::class,
    "nouvelleCommande",
    ["auth"],
);

Router::addRoute(
    "addCommande",
    CommandeController::class,
    "ajoutCommande",
    ["auth"],
);

Router::addRoute(
    "commande/addProduit",
    CommandeController::class,
    "ajouterProduit",
    ["auth"],
);

Router::addRoute(
    "commandes/retirer-produit",
    CommandeController::class,
    "retirerProduit",
    ["auth"],
);

Router::addRoute(
    "commandes/set-client",
    CommandeController::class,
    "setClient",
    ["auth"],
);

Router::addRoute(
    "commandes/enregistrer",
    CommandeController::class,
    "enregistrer",
    ["auth"],
);