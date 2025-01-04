<?php
// application/modeles/Match.php

class Match {
    private $connexion;
    private $table = "matchs";

    public $id;
    public $date_match;
    public $adversaire;
    public $lieu;
    public $resultat;

    public function __construct($db){
        $this->connexion = $db;
    }

    // Liste des matchs
    public function getAll(){
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_match DESC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un match
    public function ajouter(){
        $query = "INSERT INTO " . $this->table . " 
            SET date_match=:date_match, adversaire=:adversaire, lieu=:lieu, resultat=:resultat";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->date_match = htmlspecialchars(strip_tags($this->date_match));
        $this->adversaire = htmlspecialchars(strip_tags($this->adversaire));
        $this->lieu = htmlspecialchars(strip_tags($this->lieu));
        $this->resultat = htmlspecialchars(strip_tags($this->resultat));

        // Bind des paramètres
        $stmt->bindParam(':date_match', $this->date_match);
        $stmt->bindParam(':adversaire', $this->adversaire);
        $stmt->bindParam(':lieu', $this->lieu);
        $stmt->bindParam(':resultat', $this->resultat);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Obtenir un match par ID
    public function getById($id){
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un match
    public function modifier(){
        $query = "UPDATE " . $this->table . " 
            SET date_match=:date_match, adversaire=:adversaire, lieu=:lieu, resultat=:resultat 
            WHERE id = :id";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->date_match = htmlspecialchars(strip_tags($this->date_match));
        $this->adversaire = htmlspecialchars(strip_tags($this->adversaire));
        $this->lieu = htmlspecialchars(strip_tags($this->lieu));
        $this->resultat = htmlspecialchars(strip_tags($this->resultat));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind des paramètres
        $stmt->bindParam(':date_match', $this->date_match);
        $stmt->bindParam(':adversaire', $this->adversaire);
        $stmt->bindParam(':lieu', $this->lieu);
        $stmt->bindParam(':resultat', $this->resultat);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Supprimer un match
    public function supprimer($id){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Obtenir les matchs à venir
    public function getUpcomingMatches(){
        $query = "SELECT * FROM " . $this->table . " WHERE date_match > NOW() ORDER BY date_match ASC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les matchs terminés
    public function getCompletedMatches(){
        $query = "SELECT * FROM " . $this->table . " WHERE date_match <= NOW() ORDER BY date_match DESC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
