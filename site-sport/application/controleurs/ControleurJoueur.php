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
            $erreurs = $this->validerDonnees($_POST);
            
            if (empty($erreurs)) {
                if ($this->joueur->ajouter($_POST)) {
                    header('Location: ' . BASE_URL . 'joueurs/liste');
                    exit;
                }
            }
            $this->erreurs = $erreurs;
        }
        require_once __DIR__ . '/../vues/joueurs/ajouter.php';
    }

    public function modifier($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->joueur->modifier($id, $_POST)) {
                header('Location: ' . BASE_URL . 'joueurs/liste');
                exit;
            }
        }
        $joueur = $this->joueur->getJoueurParId($id);
        require_once __DIR__ . '/../vues/joueurs/modifier.php';
    }

    public function supprimer($id) {
        if (!$id) {
            header('Location: ' . BASE_URL . 'joueurs/liste');
            exit;
        }

        try {
            if ($this->joueur->supprimer($id)) {
                $_SESSION['message'] = "Joueur supprimé avec succès";
            } else {
                $_SESSION['erreur'] = "Erreur lors de la suppression du joueur";
            }
        } catch (Exception $e) {
            $_SESSION['erreur'] = "Erreur lors de la suppression du joueur";
        }

        header('Location: ' . BASE_URL . 'joueurs/liste');
        exit;
    }

    private function validerDonnees($data) {
        $erreurs = [];
        
        // Validation licence
        if (empty($data['numero_licence'])) {
            $erreurs[] = "Le numéro de licence est obligatoire";
        }

        // Validation nom
        if (empty($data['nom'])) {
            $erreurs[] = "Le nom est obligatoire";
        }
        
        // Validation prénom
        if (empty($data['prenom'])) {
            $erreurs[] = "Le prénom est obligatoire";
        }
        
        // Validation date
        if (empty($data['date_naissance'])) {
            $erreurs[] = "La date de naissance est obligatoire";
        }
        
        // Validation taille
        if (empty($data['taille']) || !is_numeric($data['taille'])) {
            $erreurs[] = "La taille doit être un nombre valide";
        }
        
        // Validation poids
        if (empty($data['poids']) || !is_numeric($data['poids'])) {
            $erreurs[] = "Le poids doit être un nombre valide";
        }
        
        // Validation rôle
        if (empty($data['role'])) {
            $erreurs[] = "Le poste est obligatoire";
        }

        return $erreurs;
    }
}
?>
