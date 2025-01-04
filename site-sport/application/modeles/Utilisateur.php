<?php
// application/modeles/Utilisateur.php

class Utilisateur {
    private $connexion;
    private $table = "utilisateurs";

    public $id;
    public $nom_utilisateur;
    public $mot_de_passe;

    public function __construct($db){
        $this->connexion = $db;
    }

    // Inscription d'un utilisateur
    public function inscrire(){
        $query = "INSERT INTO " . $this->table . " SET nom_utilisateur=:nom_utilisateur, mot_de_passe=:mot_de_passe";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->nom_utilisateur = htmlspecialchars(strip_tags($this->nom_utilisateur));
        $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_BCRYPT);

        // Bind des paramètres
        $stmt->bindParam(':nom_utilisateur', $this->nom_utilisateur);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Connexion d'un utilisateur
    public function connecter(){
        $query = "SELECT * FROM " . $this->table . " WHERE nom_utilisateur = :nom_utilisateur LIMIT 1";
        $stmt = $this->connexion->prepare($query);

        // Assainir l'username
        $this->nom_utilisateur = htmlspecialchars(strip_tags($this->nom_utilisateur));
        $stmt->bindParam(':nom_utilisateur', $this->nom_utilisateur);
        $stmt->execute();

        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
        if($ligne && password_verify($this->mot_de_passe, $ligne['mot_de_passe'])){
            $this->id = $ligne['id'];
            return true;
        }
        return false;
    }
}
