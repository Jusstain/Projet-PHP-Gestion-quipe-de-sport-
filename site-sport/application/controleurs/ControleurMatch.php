<?php
require_once __DIR__ . '/../../lib/Database.php';
require_once __DIR__ . '/../modeles/Rencontre.php';

class ControleurMatch {
    private $connexion;
    private $rencontre;

    public function __construct() {
        $this->connexion = Database::getInstance()->getConnection();
        $this->rencontre = new Rencontre($this->connexion);
    }

    public function liste() {
        $matchs = $this->rencontre->getTousLesMatchs();
        require_once __DIR__ . '/../vues/matchs/liste.php';
    }

    private function verifierCSRF() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }
    }

    public function ajouter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifierCSRF();
            if ($this->rencontre->ajouter($_POST)) {
                header('Location: ' . BASE_URL . 'matchs/liste');
                exit;
            }
        }
        require_once __DIR__ . '/../vues/matchs/ajouter.php';
    }

    public function selectionnerJoueurs($id_match) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->rencontre->selectionnerJoueurs($id_match, $_POST)) {
                header('Location: ' . BASE_URL . 'matchs/liste');
                exit;
            }
        }
        $match = $this->rencontre->getMatchParId($id_match);
        $joueurs_actifs = $this->rencontre->getJoueursActifs();
        require_once __DIR__ . '/../vues/matchs/selection.php';
    }

    public function evaluerJoueurs($id_match) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifierCSRF();
            if ($this->rencontre->evaluerJoueurs($id_match, $_POST)) {
                header('Location: ' . BASE_URL . 'matchs/liste');
                exit;
            }
        }
        $match = $this->rencontre->getMatchParId($id_match);
        $joueurs_selectionnes = $this->rencontre->getJoueursSelectionnes($id_match);
        require_once __DIR__ . '/../vues/matchs/evaluer.php';
    }

    public function selection() {
        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . 'matchs/liste');
            exit();
        }
        
        $id_match = $_GET['id'];
        $match = $this->rencontre->getMatchParId($id_match);
        
        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['ajouter_joueurs'])) {
                foreach ($_POST['joueurs'] as $id_joueur => $poste) {
                    if (!empty($poste)) {
                        $this->rencontre->ajouterJoueurAuMatch($id_match, $id_joueur, $poste);
                    }
                }
            }
            
            if (isset($_POST['retirer_joueur'])) {
                $this->rencontre->retirerJoueurDuMatch($id_match, $_POST['retirer_joueur']);
            }
            
            header('Location: ' . BASE_URL . 'matchs/selection?id=' . $id_match);
            exit();
        }
        
        // Get data for display
        $joueurs_disponibles = $this->rencontre->getJoueursDisponibles($id_match);
        $joueurs_selectionnes = $this->rencontre->getJoueursSelectionnes($id_match);
        
        require_once __DIR__ . '/../vues/matchs/selection_joueur.php';
    }

    public function ajouterJoueur() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }

        $id_match = $_POST['id_match'];
        $id_joueur = $_POST['id_joueur'];
        $poste = $_POST['poste'];

        if ($this->rencontre->ajouterJoueurAuMatch($id_match, $id_joueur, $poste)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false]);
        }
    }

    public function retirerJoueur() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }

        $id_match = $_POST['id_match'];
        $id_joueur = $_POST['id_joueur'];

        if ($this->rencontre->retirerJoueurDuMatch($id_match, $id_joueur)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false]);
        }
    }
}