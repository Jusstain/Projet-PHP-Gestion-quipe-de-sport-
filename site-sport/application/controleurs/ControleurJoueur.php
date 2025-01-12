<?php
require_once __DIR__ . '/../../lib/Database.php';
require_once __DIR__ . '/../modeles/Joueur.php';

class ControleurJoueur {
    private $connexion;
    private $joueur;
    private $erreurs = [];

    public function __construct() {
        $this->connexion = Database::getInstance()->getConnection();
        $this->joueur = new Joueur($this->connexion);
    }

    public function liste() {
        $joueurs = $this->joueur->getTousLesJoueurs();
        require_once __DIR__ . '/../vues/joueurs/liste.php';
    }

    private function verifierCSRF() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }
    }

    public function ajouter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifierCSRF();
            if ($this->validerDonnees($_POST)) {
                if ($this->joueur->ajouter($_POST)) {
                    header('Location: ' . BASE_URL . 'joueurs/liste');
                    exit;
                } else {
                    $this->erreurs['db'] = "Erreur lors de l'ajout";
                }
            }
        }
        require_once __DIR__ . '/../vues/joueurs/ajouter.php';
    }

    public function modifier($id) {
        error_log("Modifier joueur ID: " . $id); // Debug
        
        if (!$id) {
            header('Location: ' . BASE_URL . 'joueurs/liste');
            exit;
        }

        $joueur = $this->joueur->getJoueurParId($id);
        if (!$joueur) {
            header('Location: ' . BASE_URL . 'joueurs/liste');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->joueur->modifier($id, $_POST)) {
                header('Location: ' . BASE_URL . 'joueurs/liste');
                exit;
            }
        }

        require_once __DIR__ . '/../vues/joueurs/modifier.php';
    }

    public function supprimer($id) {
        if (!$id) {
            header('Location: ' . BASE_URL . 'joueurs/liste');
            exit;
        }

        if ($this->joueur->supprimer($id)) {
            header('Location: ' . BASE_URL . 'joueurs/liste');
            exit;
        }
    }

    private function validerDonnees($data) {
        $this->erreurs = [];
        
        // Validate name and firstname
        if (empty($data['nom']) || strlen($data['nom']) > 50) {
            $this->erreurs['nom'] = "Le nom doit contenir entre 1 et 50 caractères";
        }
        
        if (empty($data['prenom']) || strlen($data['prenom']) > 50) {
            $this->erreurs['prenom'] = "Le prénom doit contenir entre 1 et 50 caractères";
        }

        // Validate license number
        if (!preg_match("/^[0-9]{8}$/", $data['numero_licence'])) {
            $this->erreurs['numero_licence'] = "Le numéro de licence doit contenir 8 chiffres";
        }

        // Validate date of birth
        $date_naissance = new DateTime($data['date_naissance']);
        $aujourdhui = new DateTime();
        if ($date_naissance > $aujourdhui) {
            $this->erreurs['date_naissance'] = "La date de naissance ne peut pas être dans le futur";
        }

        // Validate height (between 1.00m and 2.50m)
        if (!is_numeric($data['taille']) || $data['taille'] < 1.00 || $data['taille'] > 2.50) {
            $this->erreurs['taille'] = "La taille doit être comprise entre 1.00 et 2.50 mètres";
        }

        // Validate weight (between 30kg and 150kg)
        if (!is_numeric($data['poids']) || $data['poids'] < 30 || $data['poids'] > 150) {
            $this->erreurs['poids'] = "Le poids doit être compris entre 30 et 150 kg";
        }

        // Validate status
        $statuts_valides = ['Actif', 'Blessé', 'Suspendu', 'Absent'];
        if (!in_array($data['statut'], $statuts_valides)) {
            $this->erreurs['statut'] = "Le statut n'est pas valide";
        }

        // Validate comment length
        if (strlen($data['commentaire']) > 500) {
            $this->erreurs['commentaire'] = "Le commentaire ne doit pas dépasser 500 caractères";
        }

        return empty($this->erreurs);
    }
}