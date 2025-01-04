<?php
// application/controleurs/ControleurStatistiques.php

require_once '../librairie/Database.php';
require_once '../application/modeles/Match.php';
require_once '../application/modeles/Joueur.php';
require_once '../application/modeles/EvaluationJoueur.php';

class ControleurStatistiques {
    private $connexion;
    private $match;
    private $joueur;
    private $evaluationJoueur;

    public function __construct(){
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->match = new Match($this->connexion);
        $this->joueur = new Joueur($this->connexion);
        $this->evaluationJoueur = new EvaluationJoueur($this->connexion);
    }

    // Afficher les statistiques
    public function index(){
        $this->verifierAuthentification();

        // Statistiques des matchs
        $statistiques_matchs = $this->getStatistiquesMatchs();

        // Statistiques des joueurs
        $statistiques_joueurs = $this->getStatistiquesJoueurs();

        require_once '../application/vues/statistiques/index.php';
    }

    // Méthode pour obtenir les statistiques des matchs
    private function getStatistiquesMatchs(){
        $query = "
            SELECT 
                SUM(CASE WHEN resultat = 'Victoire' THEN 1 ELSE 0 END) AS victoires,
                SUM(CASE WHEN resultat = 'Défaite' THEN 1 ELSE 0 END) AS defaites,
                SUM(CASE WHEN resultat = 'Nul' THEN 1 ELSE 0 END) AS nuls,
                COUNT(*) AS total_matchs
            FROM matchs
            WHERE resultat IS NOT NULL
        ";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour obtenir les statistiques des joueurs
    private function getStatistiquesJoueurs(){
        $query = "
            SELECT 
                j.id,
                j.prenom,
                j.nom,
                j.statut,
                j.poste_prefere,
                COUNT(CASE WHEN sm.role = 'Titulaire' THEN 1 END) AS total_titularisations,
                COUNT(CASE WHEN sm.role = 'Remplaçant' THEN 1 END) AS total_remplacements,
                AVG(ej.note) AS moyenne_notes,
                COUNT(ej.id) AS total_evaluations,
                (SELECT COUNT(*) FROM matchs m
                 JOIN selections_matchs sm2 ON m.id = sm2.match_id
                 WHERE sm2.joueur_id = j.id AND m.resultat = 'Victoire') / COUNT(ej.id) * 100 AS pourcentage_victoires
            FROM joueurs j
            LEFT JOIN selections_matchs sm ON j.id = sm.joueur_id
            LEFT JOIN evaluations_joueurs ej ON j.id = ej.joueur_id
            GROUP BY j.id
        ";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
