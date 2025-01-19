<?php
class Rencontre {
    private $connexion;
    private $table = "Rencontre";

    public function __construct($db) {
        $this->connexion = $db;
        if (!$this->connexion instanceof PDO) {
            throw new InvalidArgumentException('Expected a PDO instance.');
        }
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
        $query = "SELECT j.* 
              FROM Joueur j
              LEFT JOIN Participation p ON j.id_joueur = p.id_joueur 
              AND p.id_rencontre = :id_match
              WHERE j.statut = 'Actif' 
              AND p.id_participation IS NULL
              ORDER BY j.role";
              
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id_match' => isset($_GET['id']) ? $_GET['id'] : 0]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJoueursSelectionnes($id_match) {
        $query = "SELECT j.*,
                         p.role as participation_role,
                         p.poste as participation_poste,
                         p.id_participation,
                         p.evaluation
                  FROM Participation p
                  INNER JOIN Joueur j ON p.id_joueur = j.id_joueur
                  WHERE p.id_rencontre = :id_match
                  ORDER BY p.role = 'Titulaire' DESC,
                    CASE j.role
                        WHEN 'meneur' THEN 1
                        WHEN 'arriere' THEN 2
                        WHEN 'ailier' THEN 3
                        WHEN 'ailier fort' THEN 4
                        WHEN 'pivot' THEN 5
                    END";
    
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id_match' => $id_match]);
    
        // Récupération des résultats sous forme de tableau
        $joueurs_selectionnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Retourner le tableau directement
        return $joueurs_selectionnes;
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
        $query = "SELECT j.* 
              FROM Joueur j
              WHERE j.statut = 'Actif'
              AND j.id_joueur NOT IN (
                  SELECT p.id_joueur 
                  FROM Participation p 
                  WHERE p.id_rencontre = :id_match
              )
              ORDER BY j.role";

        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterJoueurAuMatch($id_match, $id_joueur, $role) {
        try {
            $joueur = $this->getJoueurParId($id_joueur);
            
            // Vérifier si un titulaire existe déjà pour ce poste
            if ($role === 'Titulaire' && $this->positionDejaOccupee($id_match, $joueur['role'])) {
                $_SESSION['erreur'] = "Un titulaire est déjà assigné au poste de " . $joueur['role'];
                return false;
            }
            
            $query = "INSERT INTO Participation 
                      (id_joueur, id_rencontre, poste, role) 
                      VALUES (:joueur, :match, :poste, :role)";
            
            $stmt = $this->connexion->prepare($query);
            return $stmt->execute([
                ':joueur' => $id_joueur,
                ':match' => $id_match,
                ':poste' => $joueur['role'],
                ':role' => $role
            ]);
        } catch (PDOException $e) {
            error_log("Erreur SQL: " . $e->getMessage());
            return false;
        }
    }

    public function retirerJoueurDuMatch($id_match, $id_joueur) {
        try {
            $query = "DELETE FROM Participation 
                      WHERE id_rencontre = :match 
                      AND id_joueur = :joueur";
            
            $stmt = $this->connexion->prepare($query);
            return $stmt->execute([
                ':match' => $id_match,
                ':joueur' => $id_joueur
            ]);
        } catch (PDOException $e) {
            error_log("Erreur de suppression: " . $e->getMessage());
            return false;
        }
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

    public function getNombreTitulairesParRole($id_match, $role) {
        $query = "SELECT COUNT(*) FROM Participation p 
                  INNER JOIN Joueur j ON p.id_joueur = j.id_joueur 
                  WHERE p.id_rencontre = :match 
                  AND p.role = 'titulaire' 
                  AND j.role = :joueur_role";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':match' => $id_match, ':joueur_role' => $role]);
        return $stmt->fetchColumn();
    }

    public function getNombreRemplacants($id_match) {
        $query = "SELECT COUNT(*) FROM Participation 
                  WHERE id_rencontre = :match AND role = 'remplacant'";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':match' => $id_match]);
        return $stmt->fetchColumn();
    }

    public function getJoueurParId($id_joueur) {
        $query = "SELECT * FROM Joueur WHERE id_joueur = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id' => $id_joueur]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function positionDejaOccupee($id_match, $poste) {
        $query = "SELECT COUNT(*) 
                  FROM Participation p
                  INNER JOIN Joueur j ON p.id_joueur = j.id_joueur
                  WHERE p.id_rencontre = :id_match 
                  AND j.role = :poste
                  AND p.role = 'Titulaire'";
        
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([
            ':id_match' => $id_match,
            ':poste' => $poste
        ]);
        
        return (int)$stmt->fetchColumn() > 0;
    }
}