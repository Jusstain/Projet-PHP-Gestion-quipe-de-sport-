<?php
// application/modeles/EvaluationJoueur.php

class EvaluationJoueur {
    private $connexion;
    private $table = "evaluations_joueurs";

    public $id;
    public $match_id;
    public $joueur_id;
    public $note;
    public $etoiles;

    public function __construct($db){
        $this->connexion = $db;
    }

    // Ajouter une évaluation
    public function ajouter(){
        $query = "INSERT INTO " . $this->table . " 
            SET match_id=:match_id, joueur_id=:joueur_id, note=:note, etoiles=:etoiles";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->match_id = htmlspecialchars(strip_tags($this->match_id));
        $this->joueur_id = htmlspecialchars(strip_tags($this->joueur_id));
        $this->note = htmlspecialchars(strip_tags($this->note));
        $this->etoiles = htmlspecialchars(strip_tags($this->etoiles));

        // Bind des paramètres
        $stmt->bindParam(':match_id', $this->match_id);
        $stmt->bindParam(':joueur_id', $this->joueur_id);
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':etoiles', $this->etoiles);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Mettre à jour une évaluation
    public function modifier(){
        $query = "UPDATE " . $this->table . " 
            SET note=:note, etoiles=:etoiles 
            WHERE match_id=:match_id AND joueur_id=:joueur_id";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->note = htmlspecialchars(strip_tags($this->note));
        $this->etoiles = htmlspecialchars(strip_tags($this->etoiles));
        $this->match_id = htmlspecialchars(strip_tags($this->match_id));
        $this->joueur_id = htmlspecialchars(strip_tags($this->joueur_id));

        // Bind des paramètres
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':etoiles', $this->etoiles);
        $stmt->bindParam(':match_id', $this->match_id);
        $stmt->bindParam(':joueur_id', $this->joueur_id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Obtenir une évaluation par match et joueur
    public function getByMatchEtJoueur($match_id, $joueur_id){
        $query = "SELECT * FROM " . $this->table . " WHERE match_id = :match_id AND joueur_id = :joueur_id LIMIT 1";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
        $stmt->bindParam(':joueur_id', $joueur_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
