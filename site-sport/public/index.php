<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../application/controleurs/ControleurAuthentification.php';
require_once __DIR__ . '/../application/controleurs/ControleurJoueur.php';
require_once __DIR__ . '/../application/controleurs/ControleurMatch.php';
require_once __DIR__ . '/../application/controleurs/ControleurStatistique.php';

// Check authentication
if(!isset($_SESSION['connecte']) && !strpos($route, 'connexion')) {
    header('Location: ' . BASE_URL . 'connexion');
    exit();
}

// Simple routing
$route = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$route = str_replace($base_path, '', $route);

switch($route) {
    // Authentication routes
    case '/connexion':
        $controleur = new ControleurAuthentification();
        $controleur->connexion();
        break;
    case '/deconnexion':
        $controleur = new ControleurAuthentification();
        $controleur->deconnexion();
        break;

    // Player routes
    case '/joueurs/liste':
        $controleur = new ControleurJoueur();
        $controleur->liste();
        break;
    case '/joueurs/ajouter':
        $controleur = new ControleurJoueur();
        $controleur->ajouter();
        break;
    case '/joueurs/modifier':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurJoueur();
        $controleur->modifier($id);
        break;
    case '/joueurs/supprimer':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurJoueur();
        $controleur->supprimer($id);
        break;

    // Match routes
    case '/matchs/liste':
        $controleur = new ControleurMatch();
        $controleur->liste();
        break;
    case '/matchs/ajouter':
        $controleur = new ControleurMatch();
        $controleur->ajouter();
        break;
    case '/matchs/selection':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurMatch();
        $controleur->selectionnerJoueurs($id);
        break;
    case '/matchs/evaluer':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurMatch();
        $controleur->evaluerJoueurs($id);
        break;

    // Statistics route
    case '/statistiques':
        $controleur = new ControleurStatistique();
        $controleur->afficher();
        break;

    default: 
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../application/vues/erreurs/404.php';
        break;
}