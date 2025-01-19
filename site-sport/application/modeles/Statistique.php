<?php
class Statistique {
    private $connexion;

    public function __construct($db) {
        $this->connexion = $db;
    }

    public function getStatsMatchs() {
        $query = "SELECT 
                    COUNT(*) as total_matchs,
                    SUM(CASE WHEN resultat = 'Victoire' THEN 1 ELSE 0 END) as victoires,
                    SUM(CASE WHEN resultat = 'Défaite' THEN 1 ELSE 0 END) as defaites,
                    SUM(CASE WHEN resultat = 'Nul' THEN 1 ELSE 0 END) as nuls
                 FROM Rencontre 
                 WHERE resultat IS NOT NULL";
        
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Calcul des pourcentages
        $result['pourcentage_victoires'] = $result['total_matchs'] > 0 ? round(($result['victoires'] / $result['total_matchs']) * 100, 2) : 0;
        $result['pourcentage_defaites'] = $result['total_matchs'] > 0 ? round(($result['defaites'] / $result['total_matchs']) * 100, 2) : 0;
        $result['pourcentage_nuls'] = $result['total_matchs'] > 0 ? round(($result['nuls'] / $result['total_matchs']) * 100, 2) : 0;
        
        return $result;
    }

    public function getStatsJoueurs() {
        $query = "SELECT 
                    j.id_joueur,
                    j.nom,
                    j.prenom,
                    j.statut,
                    COUNT(CASE WHEN p.role = 'Titulaire' THEN 1 END) as nb_titularisations,
                    COUNT(CASE WHEN p.role = 'Remplaçant' THEN 1 END) as nb_remplacements,
                    AVG(p.evaluation) as moyenne_evaluations,
                    (
                        SELECT poste 
                        FROM Participation p2 
                        WHERE p2.id_joueur = j.id_joueur 
                        GROUP BY poste 
                        ORDER BY COUNT(*) DESC 
                        LIMIT 1
                    ) as poste_prefere
                 FROM Joueur j
                 LEFT JOIN Participation p ON j.id_joueur = p.id_joueur
                 GROUP BY j.id_joueur";
        
        $stmt = $this->connexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
