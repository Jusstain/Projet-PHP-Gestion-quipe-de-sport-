<?php
// public/index.php

// Configurer les paramètres de session avant de démarrer la session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Assurez-vous d'utiliser HTTPS
ini_set('session.use_strict_mode', 1);

session_start();

require_once '../configuration/config.php';
require_once '../librairie/Database.php';

// Autoload des classes
spl_autoload_register(function ($class_name) {
    $chemins = [
        "../application/controleurs/$class_name.php",
        "../application/modeles/$class_name.php",
    ];

    foreach ($chemins as $chemin) {
        if (file_exists($chemin)) {
            require_once $chemin;
            return;
        }
    }
});

// Récupérer la requête URI
$requete = $_SERVER['REQUEST_URI'];
$chemin_script = dirname($_SERVER['SCRIPT_NAME']);
$chemin = str_replace($chemin_script, '', $requete);
$chemin = trim($chemin, '/');

// Routage simple basé sur l'URL
switch ($chemin) {
    case '':
    case 'connexion.php':
        $controleur = new ControleurAuthentification();
        $controleur->connexion();
        break;
    case 'inscription.php':
        $controleur = new ControleurAuthentification();
        $controleur->inscription();
        break;
    case 'deconnexion.php':
        $controleur = new ControleurAuthentification();
        $controleur->deconnexion();
        break;
    case 'joueurs/liste.php':
        $controleur = new ControleurJoueur();
        $controleur->liste();
        break;
    case 'joueurs/ajouter.php':
        $controleur = new ControleurJoueur();
        $controleur->ajouter();
        break;
    case 'joueurs/modifier.php':
        $controleur = new ControleurJoueur();
        $controleur->modifier();
        break;
    case 'joueurs/supprimer.php':
        $controleur = new ControleurJoueur();
        $controleur->supprimer();
        break;
    case 'matchs/liste.php':
        $controleur = new ControleurMatch();
        $controleur->liste();
        break;
    case 'matchs/ajouter.php':
        $controleur = new ControleurMatch();
        $controleur->ajouter();
        break;
    case 'matchs/modifier.php':
        $controleur = new ControleurMatch();
        $controleur->modifier();
        break;
    case 'matchs/supprimer.php':
        $controleur = new ControleurMatch();
        $controleur->supprimer();
        break;
    case 'matchs/evaluer.php':
        $controleur = new ControleurMatch();
        $controleur->evaluer();
        break;
    case 'selections/selectionner_joueurs.php':
        $controleur = new ControleurSelection();
        $controleur->selectionnerJoueurs();
        break;
    case 'statistiques/index.php':
        $controleur = new ControleurStatistiques();
        $controleur->index();
        break;
    default:
        echo "Page non trouvée.";
        break;
}
