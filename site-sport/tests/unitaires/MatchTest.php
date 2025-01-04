<?php
// tests/unitaires/MatchTest.php

use PHPUnit\Framework\TestCase;
require_once '../../librairie/Database.php';
require_once '../../application/modeles/Match.php';

class MatchTest extends TestCase {
    private $connexion;
    private $match;

    protected function setUp(): void {
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->match = new Match($this->connexion);
    }

    public function testAjouterMatchValide(){
        $this->match->date_match = "2024-12-31 20:00:00";
        $this->match->adversaire = "Adversaire Test";
        $this->match->lieu = "Domicile";
        $this->match->resultat = null; // Résultat non défini à l'ajout

        $resultat = $this->match->ajouter();
        $this->assertTrue($resultat);
    }

    public function testModifierMatchValide(){
        // Pré-requis : un match doit exister dans la base de données avec cet ID
        $this->match->id = 1;
        $this->match->date_match = "2025-01-01 18:00:00";
        $this->match->adversaire = "Adversaire Modifié";
        $this->match->lieu = "Extérieur";
        $this->match->resultat = "Victoire";

        $resultat = $this->match->modifier();
        $this->assertTrue($resultat);
    }

    public function testSupprimerMatchValide(){
        // Pré-requis : un match doit exister dans la base de données avec cet ID
        $match_id = 2; // Remplacez par un ID valide
        $resultat = $this->match->supprimer($match_id);
        $this->assertTrue($resultat);
    }

    // Ajoutez d'autres tests pour les différentes méthodes et scénarios
}
