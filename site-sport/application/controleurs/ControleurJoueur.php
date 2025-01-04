<?php
// application/controleurs/ControleurJoueur.php

require_once '../librairie/Database.php';
require_once '../application/modeles/Joueur.php';

class ControleurJoueur {
    private $connexion;
    private $joueur;

    public function __construct(){
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->joueur = new Joueur($this->connexion);
    }

    // Liste des joueurs
    public function liste(){
        $this->verifierAuthentification();
        $joueurs = $this->joueur->getAll();
        require_once '../application/vues/joueurs/liste.php';
    }

    // Ajouter un joueur
    public function ajouter(){
        $this->verifierAuthentification();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Récupération et validation des données
            $this->joueur->prenom = trim($_POST['prenom']);
            $this->joueur->nom = trim($_POST['nom']);
            $this->joueur->numero_licence = trim($_POST['numero_licence']);
            $this->joueur->date_naissance = $_POST['date_naissance'];
            $this->joueur->taille = trim($_POST['taille']);
            $this->joueur->poids = trim($_POST['poids']);
            $this->joueur->statut = $_POST['statut'];
            $this->joueur->commentaires = trim($_POST['commentaires']);

            // Validation des données
            if(empty($this->joueur->prenom) || empty($this->joueur->nom) || empty($this->joueur->numero_licence)){
                $erreur = "Les champs prénom, nom et numéro de licence sont requis.";
            } else {
                if($this->joueur->ajouter()){
                    header("Location: " . BASE_URL . "joueurs/liste.php");
                    exit();
                } else {
                    $erreur = "Erreur lors de l'ajout du joueur. Le numéro de licence peut déjà exister.";
                }
            }
        }
        require_once '../application/vues/joueurs/ajouter.php';
    }

    // Modifier un joueur
    public function modifier(){
        $this->verifierAuthentification();
        if(!isset($_GET['id'])){
            header("Location: " . BASE_URL . "joueurs/liste.php");
            exit();
        }

        $joueur = $this->joueur->getById($_GET['id']);
        if(!$joueur){
            header("Location: " . BASE_URL . "joueurs/liste.php");
            exit();
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Récupération et validation des données
            $this->joueur->id = $_GET['id'];
            $this->joueur->prenom = trim($_POST['prenom']);
            $this->joueur->nom = trim($_POST['nom']);
            $this->joueur->numero_licence = trim($_POST['numero_licence']);
            $this->joueur->date_naissance = $_POST['date_naissance'];
            $this->joueur->taille = trim($_POST['taille']);
            $this->joueur->poids = trim($_POST['poids']);
            $this->joueur->statut = $_POST['statut'];
            $this->joueur->commentaires = trim($_POST['commentaires']);

            // Validation des données
            if(empty($this->joueur->prenom) || empty($this->joueur->nom) || empty($this->joueur->numero_licence)){
                $erreur = "Les champs prénom, nom et numéro de licence sont requis.";
            } else {
                if($this->joueur->modifier()){
                    header("Location: " . BASE_URL . "joueurs/liste.php");
                    exit();
                } else {
                    $erreur = "Erreur lors de la mise à jour du joueur.";
                }
            }
        }

        require_once '../application/vues/joueurs/modifier.php';
    }

    // Supprimer un joueur
    public function supprimer(){
        $this->verifierAuthentification();
        if(!isset($_GET['id'])){
            header("Location: " . BASE_URL . "joueurs/liste.php");
            exit();
        }

        if($this->joueur->supprimer($_GET['id'])){
            header("Location: " . BASE_URL . "joueurs/liste.php");
            exit();
        } else {
            $erreur = "Erreur lors de la suppression du joueur.";
            // Vous pouvez rediriger avec un message d'erreur ou afficher directement
        }
    }

    // Méthode pour vérifier l'authentification
    private function verifierAuthentification(){
        session_start();
        if(!isset($_SESSION['utilisateur_id'])){
            header("Location: " . BASE_URL . "connexion.php");
            exit();
        }
    }
}
