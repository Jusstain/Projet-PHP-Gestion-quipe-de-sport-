<?php
require_once __DIR__ . '/../../lib/Database.php';
require_once __DIR__ . '/../modeles/Utilisateur.php';

class ControleurAuthentification {
    private $connexion;
    private $utilisateur;

    public function __construct() {
        $this->connexion = Database::getInstance()->getConnection();
        $this->utilisateur = new Utilisateur($this->connexion);
    }

    public function connexion() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Invalid CSRF token');
            }
            $username = trim($_POST['username']);
            $mot_de_passe = trim($_POST['mot_de_passe']);

            if($this->utilisateur->verifierIdentifiants($username, $mot_de_passe)) {
                session_regenerate_id(true);
                $_SESSION['connecte'] = true;
                header("Location: " . BASE_URL . "joueurs/liste");
                exit();
            } else {
                $erreur = "Identifiants incorrects";
            }
        }
        require_once __DIR__ . '/../vues/authentification/connexion.php';
    }

    public function deconnexion() {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL . "connexion");
        exit();
    }
}