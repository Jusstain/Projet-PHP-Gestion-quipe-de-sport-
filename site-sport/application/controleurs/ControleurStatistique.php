<?php
require_once __DIR__ . '/../../lib/Database.php';
require_once __DIR__ . '/../modeles/Statistique.php';

class ControleurStatistique {
    private $connexion;
    private $statistique;

    public function __construct() {
        $this->connexion = Database::getInstance()->getConnection();
        $this->statistique = new Statistique($this->connexion);
    }

    public function afficher() {
        // Get match statistics with percentages
        $stats_matchs = $this->statistique->getStatsMatchs();
        
        // Get player statistics
        $stats_joueurs = $this->statistique->getStatsJoueurs();
        
        // Pass data to the view
        require_once __DIR__ . '/../vues/statistiques/index.php';
    }
}
?>
