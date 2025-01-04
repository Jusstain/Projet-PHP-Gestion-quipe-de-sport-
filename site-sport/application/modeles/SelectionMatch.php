<?php
// application/modeles/SelectionMatch.php

class SelectionMatch {
    private $connexion;
    private $table = "selections_matchs";

    public $id;
    public $match_id;
    public $joueur_id;
    public $role;
    public $poste;

    public function __construct($db){
        $this->connexion = $db;
    }

    // Ajouter une sélection
    public function ajouter(){
        $query = "INSERT INTO " . $this->table . " 
            SET match_id=:match_id, joueur_id=:joueur_id, role=:role, poste=:poste";
        $stmt = $this->connexion->prepare($query);

        // Assainir les données
        $this->match_id = htmlspecialchars(strip_tags($this->match_id));
        $this->joueur_id = htmlspecialchars(strip_tags($this->joueur_id));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->poste = htmlspecialchars(strip_tags($this->poste));

        // Bind des paramètres
        $stmt->bindParam(':match_id', $this->match_id);
        $stmt->bindParam(':joueur_id', $this->joueur_id);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':poste', $this->poste);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Supprimer les sélections d'un match
    public function supprimerParMatchId($match_id){
        $query = "DELETE FROM " . $this->table . " WHERE match_id = :match_id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Obtenir les sélections pour un match
    public function getByMatchId($match_id){
        $query = "SELECT sm.*, j.prenom, j.nom, j.taille, j.poids, j.commentaires
                  FROM " . $this->table . " sm
                  JOIN joueurs j ON sm.joueur_id = j.id
                  WHERE sm.match_id = :match_id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
