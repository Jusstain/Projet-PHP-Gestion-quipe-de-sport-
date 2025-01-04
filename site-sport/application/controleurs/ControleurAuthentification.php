<?php
// application/controleurs/ControleurAuthentification.php
//test
require_once '../librairie/Database.php';
require_once '../application/modeles/Utilisateur.php';

class ControleurAuthentification {
    private $connexion;
    private $utilisateur;

    public function __construct(){
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->utilisateur = new Utilisateur($this->connexion);
    }

    // Méthode pour l'inscription
    public function inscription(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Validation des données
            $nom_utilisateur = trim($_POST['nom_utilisateur']);
            $mot_de_passe = trim($_POST['mot_de_passe']);
            $confirmer_mot_de_passe = trim($_POST['confirmer_mot_de_passe']);

            // Vérifications de base
            if(empty($nom_utilisateur) || empty($mot_de_passe) || empty($confirmer_mot_de_passe)){
                $erreur = "Tous les champs sont requis.";
            } elseif($mot_de_passe !== $confirmer_mot_de_passe){
                $erreur = "Les mots de passe ne correspondent pas.";
            } else {
                $this->utilisateur->nom_utilisateur = $nom_utilisateur;
                $this->utilisateur->mot_de_passe = $mot_de_passe;

                if($this->utilisateur->inscrire()){
                    header("Location: " . BASE_URL . "connexion.php");
                    exit();
                } else {
                    $erreur = "Erreur lors de l'inscription. Le nom d'utilisateur peut déjà exister.";
                }
            }
        }
        require_once '../application/vues/authentification/inscription.php';
    }

    // Méthode pour la connexion
    public function connexion(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $nom_utilisateur = trim($_POST['nom_utilisateur']);
            $mot_de_passe = trim($_POST['mot_de_passe']);

            if(empty($nom_utilisateur) || empty($mot_de_passe)){
                $erreur = "Tous les champs sont requis.";
            } else {
                $this->utilisateur->nom_utilisateur = $nom_utilisateur;
                $this->utilisateur->mot_de_passe = $mot_de_passe;

                if($this->utilisateur->connecter()){
                    session_regenerate_id(true); // Sécurité supplémentaire
                    $_SESSION['utilisateur_id'] = $this->utilisateur->id;
                    header("Location: " . BASE_URL . "joueurs/liste.php");
                    exit();
                } else {
                    $erreur = "Identifiants incorrects.";
                }
            }
        }
        require_once '../application/vues/authentification/connexion.php';
    }

    // Méthode pour la déconnexion
    public function deconnexion(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL . "connexion.php");
        exit();
    }
}
