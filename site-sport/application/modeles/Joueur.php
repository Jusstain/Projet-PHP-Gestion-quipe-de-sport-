<?php
class Joueur {
    private $connexion;
    private $table = "Joueur";

    public function __construct($db) {
        $this->connexion = $db;
    }

    public function getTousLesJoueurs() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nom, prenom";
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
        // Validation du numéro de licence : doit être composé de 8 chiffres
        if (strlen($data['numero_licence']) != 8 || !preg_match('/^\d{8}$/', $data['numero_licence'])) {
            throw new Exception('Le numéro de licence doit être composé de 8 chiffres.');
        }

        // Vérification si le numéro de licence existe déjà
        $query = "SELECT * FROM " . $this->table . " WHERE numero_licence = :numero_licence";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([':numero_licence' => $data['numero_licence']]);
        if ($stmt->rowCount() > 0) {
            throw new PDOException('Le numéro de licence existe déjà pour un autre joueur.');
        }

        // Code pour ajouter un joueur
        $query = "INSERT INTO " . $this->table . " 
                (nom, prenom, numero_licence, date_naissance, taille, poids, statut, commentaire) 
                VALUES (:nom, :prenom, :numero_licence, :date_naissance, :taille, :poids, :statut, :commentaire)";
        
        $stmt = $this->connexion->prepare($query);
        
        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':numero_licence' => $data['numero_licence'],
            ':date_naissance' => $data['date_naissance'],
            ':taille' => $data['taille'],
            ':poids' => $data['poids'],
            ':statut' => $data['statut'] ?? 'Actif',
            ':commentaire' => $data['commentaire'] ?? null
        ]);
    }

    public function modifier($id, $data) {
        // Validation du numéro de licence : doit être composé de 8 chiffres
        if (strlen($data['numero_licence']) != 8 || !preg_match('/^\d{8}$/', $data['numero_licence'])) {
            throw new Exception('Le numéro de licence doit être composé de 8 chiffres.');
        }
    
        // Vérification si le numéro de licence existe déjà (exclure le joueur actuel)
        $query = "SELECT * FROM " . $this->table . " WHERE numero_licence = :numero_licence AND id_joueur != :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->execute([
            ':numero_licence' => $data['numero_licence'],
            ':id' => $id
        ]);
        
        if ($stmt->rowCount() > 0) {
            throw new PDOException('Le numéro de licence existe déjà pour un autre joueur.');
        }
    
        // Code pour modifier un joueur
        $query = "UPDATE " . $this->table . " 
                SET nom = :nom, 
                    prenom = :prenom, 
                    numero_licence = :numero_licence, 
                    date_naissance = :date_naissance, 
                    taille = :taille, 
                    poids = :poids, 
                    statut = :statut, 
                    commentaire = :commentaire 
                WHERE id_joueur = :id";
        
        $stmt = $this->connexion->prepare($query);
        
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':numero_licence' => $data['numero_licence'],
            ':date_naissance' => $data['date_naissance'],
            ':taille' => $data['taille'],
            ':poids' => $data['poids'],
            ':statut' => $data['statut'],
            ':commentaire' => $data['commentaire']
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
