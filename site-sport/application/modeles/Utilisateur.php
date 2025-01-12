<?php
class Utilisateur {
    private $connexion;
    private $table = "Utilisateur";

    // Identifiants prédéfinis avec mot de passe hashé
    private const USERNAME = "admin";
    // Le mot de passe est "admin123"
    private const PASSWORD_HASH = '$2y$10$royrMgb2/NX3gcNM.pE1JO.0iOAndTXdWMHA9boLw1qCMYaZlItSW';

    public function __construct($db) {
        $this->connexion = $db;
    }

    public function verifierIdentifiants($username, $mot_de_passe) {
        error_log("Checking credentials for: " . $username);
        error_log("Received password: " . $mot_de_passe);
        error_log("Stored hash: " . self::PASSWORD_HASH);
        
        $isValidPassword = password_verify($mot_de_passe, self::PASSWORD_HASH);
        error_log("Password verification result: " . ($isValidPassword ? 'true' : 'false'));
        
        return ($username === self::USERNAME && $isValidPassword);
    }
}
