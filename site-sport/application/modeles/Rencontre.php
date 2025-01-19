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
        $query = "SELECT j.*, p.id_rencontre, p.role as participation_role 
              FROM Joueur j 
              INNER JOIN Participation p ON j.id_joueur = p.id_joueur 
              WHERE p.id_rencontre = :id_match
              ORDER BY p.role, 
                CASE j.role
                    WHEN 'meneur' THEN 1
                    WHEN 'arriere' THEN 2
                    WHEN 'ailier' THEN 3
                    WHEN 'ailier fort' THEN 4
                    WHEN 'pivot' THEN 5
                END";
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
        $query = "SELECT j.* FROM Joueur j 
             WHERE j.statut = 'Actif' 
             AND j.id_joueur NOT IN (
                SELECT p.id_joueur 
                FROM Participation p 
                WHERE p.id_rencontre = :id_match
             )
             ORDER BY CASE j.role
                WHEN 'meneur' THEN 1
                WHEN 'arriere' THEN 2
                WHEN 'ailier' THEN 3
                WHEN 'ailier fort' THEN 4
                WHEN 'pivot' THEN 5
             END";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterJoueurAuMatch($id_match, $id_joueur, $participation_role = 'remplacant') {
        $query = "INSERT INTO Participation (id_rencontre, id_joueur, role) 
              VALUES (:match, :joueur, :role)";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':match' => $id_match,
            ':joueur' => $id_joueur,
            ':role' => $participation_role
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

    public function supprimerMatch($id) {
        try {
            // D'abord supprimer les participations liées au match
            $query = "DELETE FROM Participation WHERE id_rencontre = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([':id' => $id]);
            
            // Ensuite supprimer le match
            $query = "DELETE FROM " . $this->table . " WHERE id_rencontre = :id";
            $stmt = $this->connexion->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur de suppression : " . $e->getMessage());
            return false;
        }
    }

    public function setResultat($id_match, $resultat) {
        $query = "UPDATE Rencontre 
                  SET resultat = :resultat, 
                      statut = 'passé' 
                  WHERE id_rencontre = :id";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':id' => $id_match,
            ':resultat' => $resultat
        ]);
    }

    public function getMatchsPasses() {
        $query = "SELECT * FROM Rencontre WHERE statut = 'passé' ORDER BY date_heure DESC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMatchsAVenir() {
        $query = "SELECT * FROM Rencontre WHERE resultat IS NULL ORDER BY date_heure ASC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMatchsTermines() {
        $query = "SELECT * FROM Rencontre WHERE resultat IS NOT NULL ORDER BY date_heure DESC";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}