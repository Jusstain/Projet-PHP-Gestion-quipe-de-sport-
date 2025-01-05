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
        $query = "DELETE FROM " . $this->table . " WHERE id_joueur = :id";
        $stmt = $this->connexion->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}