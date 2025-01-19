<?php
class Joueur {
    private $connexion;
    private $table = "Joueur";

    public function __construct($db) {
        $this->connexion = $db;
    }

    public function getTousLesJoueurs() {
        $query = "SELECT *, 
                  COALESCE(commentaire, '') as commentaire 
                  FROM Joueur 
                  ORDER BY nom, prenom";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJoueurParId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_joueur = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouter($data) {
        $query = "INSERT INTO Joueur (nom, prenom, date_naissance, taille, poids, role, commentaire, numero_licence, statut) 
                  VALUES (:nom, :prenom, :date_naissance, :taille, :poids, :role, :commentaire, :numero_licence, :statut)";
        
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':date_naissance' => $data['date_naissance'],
            ':taille' => (float)$data['taille'],
            ':poids' => (float)$data['poids'],
            ':role' => $data['role'],
            ':commentaire' => !empty($data['commentaire']) ? $data['commentaire'] : null,
            ':numero_licence' => $data['numero_licence'],
            ':statut' => 'Actif'
        ]);
    }

    public function modifier($id, $data) {
        $query = "UPDATE Joueur 
                  SET nom = :nom, 
                      prenom = :prenom, 
                      date_naissance = :date_naissance,
                      taille = :taille,
                      poids = :poids,
                      role = :role,
                      commentaire = :commentaire,
                      numero_licence = :numero_licence,
                      statut = :statut
                  WHERE id_joueur = :id_joueur";
        
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([
            ':id_joueur' => $id,
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':date_naissance' => $data['date_naissance'],
            ':taille' => (float)$data['taille'],
            ':poids' => (float)$data['poids'],
            ':role' => $data['role'],
            ':commentaire' => !empty($data['commentaire']) ? $data['commentaire'] : null,
            ':numero_licence' => $data['numero_licence'],
            ':statut' => $data['statut']
        ]);
    }

    public function supprimer($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_joueur = :id";
            $stmt = $this->connexion->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur de suppression : " . $e->getMessage());
            return false;
        }
    }
}
?>
