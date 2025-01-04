<?php
// application/controleurs/ControleurMatch.php

require_once '../librairie/Database.php';
require_once '../application/modeles/Match.php';
require_once '../application/modeles/EvaluationJoueur.php';

class ControleurMatch {
    private $connexion;
    private $match;
    private $evaluationJoueur;

    public function __construct(){
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->match = new Match($this->connexion);
        $this->evaluationJoueur = new EvaluationJoueur($this->connexion);
    }

    // Liste des matchs
    public function liste(){
        $this->verifierAuthentification();
        $matchs = $this->match->getAll();
        require_once '../application/vues/matchs/liste.php';
    }

    // Ajouter un match
    public function ajouter(){
        $this->verifierAuthentification();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Récupération et validation des données
            $this->match->date_match = $_POST['date_match'];
            $this->match->adversaire = trim($_POST['adversaire']);
            $this->match->lieu = $_POST['lieu'];
            $this->match->resultat = $_POST['resultat'] ?? null; // Résultat peut être null à l'ajout

            // Validation des données
            if(empty($this->match->date_match) || empty($this->match->adversaire) || empty($this->match->lieu)){
                $erreur = "Les champs date, adversaire et lieu sont requis.";
            } else {
                if($this->match->ajouter()){
                    header("Location: " . BASE_URL . "matchs/liste.php");
                    exit();
                } else {
                    $erreur = "Erreur lors de l'ajout du match.";
                }
            }
        }
        require_once '../application/vues/matchs/ajouter.php';
    }

    // Modifier un match
    public function modifier(){
        $this->verifierAuthentification();
        if(!isset($_GET['id'])){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        $match = $this->match->getById($_GET['id']);
        if(!$match){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Récupération et validation des données
            $this->match->id = $_GET['id'];
            $this->match->date_match = $_POST['date_match'];
            $this->match->adversaire = trim($_POST['adversaire']);
            $this->match->lieu = $_POST['lieu'];
            $this->match->resultat = $_POST['resultat'];

            // Validation des données
            if(empty($this->match->date_match) || empty($this->match->adversaire) || empty($this->match->lieu)){
                $erreur = "Les champs date, adversaire et lieu sont requis.";
            } else {
                if($this->match->modifier()){
                    header("Location: " . BASE_URL . "matchs/liste.php");
                    exit();
                } else {
                    $erreur = "Erreur lors de la mise à jour du match.";
                }
            }
        }

        require_once '../application/vues/matchs/modifier.php';
    }

    // Supprimer un match
    public function supprimer(){
        $this->verifierAuthentification();
        if(!isset($_GET['id'])){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        if($this->match->supprimer($_GET['id'])){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        } else {
            $erreur = "Erreur lors de la suppression du match.";
            // Vous pouvez rediriger avec un message d'erreur ou afficher directement
        }
    }

    // Méthode pour évaluer un match
    public function evaluer(){
        $this->verifierAuthentification();
        if(!isset($_GET['id'])){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        $match_id = $_GET['id'];
        $match = $this->match->getById($match_id);
        if(!$match || strtotime($match['date_match']) > time()){
            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        // Récupérer les joueurs sélectionnés pour le match
        $query = "SELECT sm.*, j.prenom, j.nom
                  FROM selections_matchs sm
                  JOIN joueurs j ON sm.joueur_id = j.id
                  WHERE sm.match_id = :match_id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
        $stmt->execute();
        $joueurs_selectionnes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultat = $_POST['resultat'];
            $this->match->id = $match_id;
            $this->match->resultat = $resultat;

            // Mettre à jour le résultat du match
            $this->match->modifier();

            // Saisir les évaluations
            foreach($joueurs_selectionnes as $joueur){
                $joueur_id = $joueur['joueur_id'];
                $note = $_POST['notes'][$joueur_id];
                $etoiles = $_POST['etoiles'][$joueur_id];

                $this->evaluationJoueur->match_id = $match_id;
                $this->evaluationJoueur->joueur_id = $joueur_id;
                $this->evaluationJoueur->note = $note;
                $this->evaluationJoueur->etoiles = $etoiles;
                $this->evaluationJoueur->ajouter();
            }

            header("Location: " . BASE_URL . "matchs/liste.php");
            exit();
        }

        require_once '../application/vues/matchs/evaluer.php';
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
