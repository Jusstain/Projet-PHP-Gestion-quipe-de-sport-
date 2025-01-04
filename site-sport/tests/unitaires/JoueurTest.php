<?php
// tests/unitaires/JoueurTest.php

use PHPUnit\Framework\TestCase;
require_once '../../librairie/Database.php';
require_once '../../application/modeles/Joueur.php';

class JoueurTest extends TestCase {
    private $connexion;
    private $joueur;

    protected function setUp(): void {
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->joueur = new Joueur($this->connexion);
    }

    public function testAjouterJoueurValide(){
        $this->joueur->prenom = "Test";
        $this->joueur->nom = "Joueur";
        $this->joueur->numero_licence = "LIC" . uniqid();
        $this->joueur->date_naissance = "1990-01-01";
        $this->joueur->taille = 180;
        $this->joueur->poids = 75;
        $this->joueur->statut = "Actif";
        $this->joueur->commentaires = "Aucun";

        $resultat = $this->joueur->ajouter();
        $this->assertTrue($resultat);
    }

    public function testModifierJoueurValide(){
        // Pré-requis : un joueur doit exister dans la base de données avec cet ID
        $this->joueur->id = 1;
        $this->joueur->prenom = "Modifié";
        $this->joueur->nom = "Joueur";
        $this->joueur->numero_licence = "LICMOD" . uniqid();
        $this->joueur->date_naissance = "1991-02-02";
        $this->joueur->taille = 185;
        $this->joueur->poids = 80;
        $this->joueur->statut = "Blessé";
        $this->joueur->commentaires = "Blessure à la cheville";

        $resultat = $this->joueur->modifier();
        $this->assertTrue($resultat);
    }

    public function testSupprimerJoueurValide(){
        // Pré-requis : un joueur doit exister dans la base de données avec cet ID
        $joueur_id = 2; // Remplacez par un ID valide
        $resultat = $this->joueur->supprimer($joueur_id);
        $this->assertTrue($resultat);
    }

    // Ajoutez d'autres tests pour les différentes méthodes et scénarios
}
