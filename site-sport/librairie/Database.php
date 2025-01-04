<?php
// librairie/Database.php

require_once '../configuration/database.php';

class DatabaseConnection {
    private $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function getConnection(){
        return $this->database->getConnexion();
    }
}
