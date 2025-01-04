<?php
// application/controleurs/ControleurSelection.php

require_once '../librairie/Database.php';
require_once '../application/modeles/Match.php';
require_once '../application/modeles/Joueur.php';
require_once '../application/modeles/SelectionMatch.php';

class ControleurSelection {
    private $connexion;
    private $match;
    private $joueur;
    private $selectionMatch;

    public function __construct(){
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->match = new Match($this->connexion);
        $this->joueur = new Joueur($this->connexion);
        $this->selectionMatch = new SelectionMatch($this->connexion);
    }

    // Sélectionner les joueurs pour un match
    public function selectionnerJoueurs(){
        $this->verifierAuthentification();

        if(!isset($_GET['match_id'])){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        $match_id = $_GET['match_id'];
        $match = $this->match->getById($match_id);
        if(!$match || strtotime($match['date_match']) <= time()){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        // Récupérer les joueurs actifs
        $query = "SELECT * FROM joueurs WHERE statut = 'Actif' ORDER BY nom ASC, prenom ASC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        $joueurs_actifs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les sélections existantes
        $selections_existantes = $this->selectionMatch->getByMatchId($match_id);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Supprimer les sélections existantes
            $this->selectionMatch->supprimerParMatchId($match_id);

            // Ajouter les nouvelles sélections
            if(isset($_POST['selections'])){
                foreach($_POST['selections'] as $selection){
                    // Validation basique
                    if(isset($selection['joueur_id']) && isset($selection['role']) && isset($selection['poste'])){
                        $this->selectionMatch->match_id = $match_id;
                        $this->selectionMatch->joueur_id = $selection['joueur_id'];
                        $this->selectionMatch->role = $selection['role'];
                        $this->selectionMatch->poste = $selection['poste'];
                        $this->selectionMatch->ajouter();
                    }
                }
            }

            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        require_once '../application/vues/selections/selectionner_joueurs.php';
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
