<?php
class Utilisateur {
    private $connexion;
    private $table = "Utilisateur";

    // Identifiants prédéfinis avec mot de passe hashé
    private const USERNAME = "admin";
    private const PASSWORD_HASH = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password: "admin123"

    public function __construct($db) {
        $this->connexion = $db;
    }

    public function verifierIdentifiants($username, $mot_de_passe) {
        return ($username === self::USERNAME && password_verify($mot_de_passe, self::PASSWORD_HASH));
    }
}