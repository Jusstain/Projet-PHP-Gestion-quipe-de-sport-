<?php
// Set proper encoding
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Démarrer la session avant toute chose
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug with proper encoding
error_log("Route actuelle: " . $_SERVER['REQUEST_URI']);
error_log("POST data: " . print_r($_POST, true));
error_log("Session data: " . print_r($_SESSION, true));

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../application/controleurs/ControleurAuthentification.php';
require_once __DIR__ . '/../application/controleurs/ControleurJoueur.php';
require_once __DIR__ . '/../application/controleurs/ControleurMatch.php';
require_once __DIR__ . '/../application/controleurs/ControleurStatistique.php';

// Get the current route
$route = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$route = str_replace($base_path, '', $route);

// Check if we're on the login page
$isLoginPage = $route === '/connexion' || $route === '/';

// Check authentication
if (!isset($_SESSION['connecte']) && !$isLoginPage) {
    header('Location: ' . BASE_URL . 'connexion');
    exit();
} elseif (isset($_SESSION['connecte']) && $isLoginPage) {
    header('Location: ' . BASE_URL . 'joueurs/liste');
    exit();
}

switch($route) {
    case '/':
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
        
    case (preg_match('/^\/joueurs\/modifier/', $route) ? true : false):
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurJoueur();
        $controleur->modifier($id);
        break;
        
    case (preg_match('/^\/joueurs\/supprimer/', $route) ? true : false):
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
        
    case (preg_match('/^\/matchs\/selection\?id=\d+$/', $route) ? true : false):
        $controleur = new ControleurMatch();
        $controleur->selection();
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

    // New match routes
    case '/matchs/ajouter-joueur':
        $controleur = new ControleurMatch();
        $controleur->ajouterJoueur();
        break;

    case '/matchs/retirer-joueur':
        $controleur = new ControleurMatch();
        $controleur->retirerJoueur();
        break;

    case (preg_match('/^\/matchs\/supprimer/', $route) ? true : false):
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurMatch();
        $controleur->supprimer($id);
        break;

    case '/matchs/resultat':
        $controleur = new ControleurMatch();
        $controleur->resultat();
        break;

    case '/matchs/selection':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controleur = new ControleurMatch();
        $controleur->selection();
        break;

    default: 
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../application/vues/erreurs/404.php';
        break;
}