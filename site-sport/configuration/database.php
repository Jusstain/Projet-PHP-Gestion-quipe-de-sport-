<?php
// configuration/database.php

class Database {
    private $hote = "localhost";
    private $nom_base = "gestion_equipe_sportive";
    private $utilisateur = "root";
    private $mot_de_passe = "";
    public $connexion;

    public function getConnexion(){
        $this->connexion = null;
        try{
            $this->connexion = new PDO("mysql:host=" . $this->hote . ";dbname=" . $this->nom_base,
                                      $this->utilisateur, $this->mot_de_passe);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }
        return $this->connexion;
    }
}
