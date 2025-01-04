<?php
// tests/unitaires/UtilisateurTest.php

use PHPUnit\Framework\TestCase;
require_once '../../librairie/Database.php';
require_once '../../application/modeles/Utilisateur.php';

class UtilisateurTest extends TestCase {
    private $connexion;
    private $utilisateur;

    protected function setUp(): void {
        $database = new DatabaseConnection();
        $this->connexion = $database->getConnection();
        $this->utilisateur = new Utilisateur($this->connexion);
    }

    public function testInscriptionUtilisateurValide(){
        $this->utilisateur->nom_utilisateur = "testuser_" . uniqid();
        $this->utilisateur->mot_de_passe = "MotDePasseSecurise123";
        $resultat = $this->utilisateur->inscrire();
        $this->assertTrue($resultat);
    }

    public function testConnexionUtilisateurValide(){
        // Pré-requis : un utilisateur doit exister dans la base de données avec ces identifiants
        $this->utilisateur->nom_utilisateur = "utilisateur_existant";
        $this->utilisateur->mot_de_passe = "motdepasse_correct";
        $resultat = $this->utilisateur->connecter();
        $this->assertTrue($resultat);
    }

    public function testConnexionUtilisateurInvalide(){
        $this->utilisateur->nom_utilisateur = "utilisateur_inexistant";
        $this->utilisateur->mot_de_passe = "motdepasse_errone";
        $resultat = $this->utilisateur->connecter();
        $this->assertFalse($resultat);
    }

    // Ajoutez d'autres tests pour les différentes méthodes et scénarios
}
