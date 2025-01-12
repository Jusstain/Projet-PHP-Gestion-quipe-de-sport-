<?php
require_once __DIR__ . '/../../lib/Database.php';
require_once __DIR__ . '/../modeles/Utilisateur.php';

class ControleurAuthentification {
    private $connexion;
    private $utilisateur;
    private $erreurs = [];

    public function __construct() {
        $this->connexion = Database::getInstance()->getConnection();
        $this->utilisateur = new Utilisateur($this->connexion);
    }

    public function connexion() {
        // Debug authentication flow
        error_log("=== Starting authentication process ===");
        error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data: " . print_r($_POST, true));
        error_log("Session before: " . print_r($_SESSION, true));

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $mot_de_passe = trim($_POST['mot_de_passe'] ?? '');

            error_log("Attempting login with username: " . $username);

            if($this->utilisateur->verifierIdentifiants($username, $mot_de_passe)) {
                error_log("Credentials verified successfully");
                
                // Clear any existing session data
                session_unset();
                
                // Set new session data
                $_SESSION['connecte'] = true;
                $_SESSION['username'] = $username;
                
                error_log("Session after login: " . print_r($_SESSION, true));
                error_log("Redirecting to: " . BASE_URL . "joueurs/liste");
                
                // Force session write
                session_write_close();
                
                // Redirect with absolute URL
                $redirectUrl = "http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "joueurs/liste";
                header("Location: " . $redirectUrl);
                exit();
            } else {
                error_log("Authentication failed for username: " . $username);
                $this->erreurs[] = "Identifiants incorrects";
            }
        }
        require_once __DIR__ . '/../vues/authentification/connexion.php';
    }

    public function deconnexion() {
        $_SESSION = array();
        session_destroy();
        header("Location: " . BASE_URL . "connexion");
        exit();
    }
}