<?php
// application/modeles/Joueur.php

class Joueur {
    private $connexion;
    private $table = "joueurs";

    public $id;
    public $prenom;
    public $nom;
    public $numero_licence;
    public $date_naissance;
    public $taille;
    public $poids;
    public $statut;
    public $commentaires;

    public function __construct($db){
        $this->connexion = $db;
    }

    // Liste des joueurs
    public function getAll(){
        $query = "SELECT * FROM " . $this->table . " ORDER BY nom ASC, prenom ASC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un joueur
    public function ajouter(){
        $query = "INSERT INTO " . $this->table . " 
            SET prenom=:prenom, nom=:nom, numero_licence=:numero_licence, 
                date_naissance=:date_naissance, taille=:taille, poids=:poids, statut=:statut, commentaires=:commentaires";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->numero_licence = htmlspecialchars(strip_tags($this->numero_licence));
        $this->date_naissance = htmlspecialchars(strip_tags($this->date_naissance));
        $this->taille = htmlspecialchars(strip_tags($this->taille));
        $this->poids = htmlspecialchars(strip_tags($this->poids));
        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->commentaires = htmlspecialchars(strip_tags($this->commentaires));

        // Bind des paramètres
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':numero_licence', $this->numero_licence);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':taille', $this->taille);
        $stmt->bindParam(':poids', $this->poids);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':commentaires', $this->commentaires);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Obtenir un joueur par ID
    public function getById($id){
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un joueur
    public function modifier(){
        $query = "UPDATE " . $this->table . " 
            SET prenom=:prenom, nom=:nom, numero_licence=:numero_licence, 
                date_naissance=:date_naissance, taille=:taille, poids=:poids, statut=:statut, commentaires=:commentaires 
            WHERE id = :id";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->numero_licence = htmlspecialchars(strip_tags($this->numero_licence));
        $this->date_naissance = htmlspecialchars(strip_tags($this->date_naissance));
        $this->taille = htmlspecialchars(strip_tags($this->taille));
        $this->poids = htmlspecialchars(strip_tags($this->poids));
        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->commentaires = htmlspecialchars(strip_tags($this->commentaires));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind des paramètres
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':numero_licence', $this->numero_licence);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':taille', $this->taille);
        $stmt->bindParam(':poids', $this->poids);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':commentaires', $this->commentaires);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Supprimer un joueur
    public function supprimer($id){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
