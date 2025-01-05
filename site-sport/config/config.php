<?php
// Constantes de l'application
define('BASE_URL', '/Projet-PHP-Gestion-quipe-de-sport-/site-sport/public/');

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_equipe_sportive');
define('DB_USER', 'root');
define('DB_PASS', '');

// Inclusion de la classe Database
require_once __DIR__ . '/../lib/Database.php';

// Gestion des erreurs en développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only generate CSRF if session active
if (session_status() === PHP_SESSION_ACTIVE && empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
