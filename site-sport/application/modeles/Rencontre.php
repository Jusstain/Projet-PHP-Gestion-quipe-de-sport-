<?php
class Rencontre {
    private $connexion;
    private $table = "Rencontre";

    public function __construct($db) {
        $this->connexion = $db;
    }

    public function getTousLesMatchs() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_heure";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMatchParId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_rencontre = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouter($data) {
        $query = "INSERT INTO " . $this->table . " 
                (date_heure, equipe_adverse, lieu) 
                VALUES (:date_heure, :equipe_adverse, :lieu)";
        
        $stmt = $this->connexion->prepare($query);
        
        return $stmt->execute([
            ':date_heure' => $data['date_heure'],
            ':equipe_adverse' => $data['equipe_adverse'],
            ':lieu' => $data['lieu']
        ]);
    }

    public function getJoueursActifs() {
        $query = "SELECT * FROM Joueur WHERE statut = 'Actif'";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJoueursSelectionnes($id_match) {
        $query = "SELECT j.*, p.role, p.poste, p.evaluation 
                 FROM Joueur j 
                 INNER JOIN Participation p ON j.id_joueur = p.id_joueur 
                 WHERE p.id_rencontre = :id_match";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectionnerJoueurs($id_match, $data) {
        $query = "INSERT INTO Participation 
                (id_joueur, id_rencontre, poste, role) 
                VALUES (:id_joueur, :id_rencontre, :poste, :role)";
        
        $stmt = $this->connexion->prepare($query);
        
        foreach($data['joueurs'] as $joueur) {
            $stmt->execute([
                ':id_joueur' => $joueur['id'],
                ':id_rencontre' => $id_match,
                ':poste' => $joueur['poste'],
                ':role' => $joueur['role']
            ]);
        }
        return true;
    }

    public function evaluerJoueurs($id_match, $data) {
        $query = "UPDATE Participation 
                SET evaluation = :evaluation 
                WHERE id_joueur = :id_joueur 
                AND id_rencontre = :id_rencontre";
        
        $stmt = $this->connexion->prepare($query);
        
        foreach($data['evaluations'] as $id_joueur => $evaluation) {
            $stmt->execute([
                ':evaluation' => $evaluation,
                ':id_joueur' => $id_joueur,
                ':id_rencontre' => $id_match
            ]);
        }
        return true;
    }

    public function getJoueursDisponibles($id_match) {
        $query = "SELECT * FROM Joueur 
                 WHERE statut = 'Actif' 
                 AND id_joueur NOT IN (
                    SELECT id_joueur 
                    FROM Participation 
                    WHERE id_rencontre = :id_match
                 )";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterJoueurAuMatch($id_match, $id_joueur, $poste) {
        $query = "INSERT INTO Participation (id_rencontre, id_joueur, poste) 
                  VALUES (:match, :joueur, :poste)";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':match' => $id_match,
            ':joueur' => $id_joueur,
            ':poste' => $poste
        ]);
    }

    public function retirerJoueurDuMatch($id_match, $id_joueur) {
        $query = "DELETE FROM Participation 
                  WHERE id_rencontre = :match AND id_joueur = :joueur";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':match' => $id_match,
            ':joueur' => $id_joueur
        ]);
    }
}