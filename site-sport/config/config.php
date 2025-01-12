<?php
// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// Constantes de l'application
define('BASE_URL', '/Projet-PHP-Gestion-quipe-de-sport-/site-sport/public/');

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_equipe_sportive');
define('DB_USER', 'root');
define('DB_PASS', '');

// Gestion des erreurs en développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Generate CSRF token if needed
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Inclusion de la classe Database
require_once __DIR__ . '/../lib/Database.php';