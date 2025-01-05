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
}