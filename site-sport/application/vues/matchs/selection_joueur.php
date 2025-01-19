<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection des Joueurs</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php if (isset($_SESSION['erreur'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['erreur'] ?>
            <?php unset($_SESSION['erreur']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <nav class="header">
        <a href="<?= BASE_URL ?>joueurs/liste">Joueurs</a>
        <a href="<?= BASE_URL ?>matchs/liste">Matchs</a>
        <a href="<?= BASE_URL ?>statistiques">Statistiques</a>
        <a href="<?= BASE_URL ?>deconnexion">Déconnexion</a>
    </nav>
    
    <div class="container">
        <h2>Sélection des Joueurs - Match du <?= htmlspecialchars($match['date_heure']) ?></h2>
        <h3>Contre <?= htmlspecialchars($match['equipe_adverse']) ?></h3>

        <div class="selection-container">
            <?php
            $roles = [
                'meneur' => '1',
                'arriere' => '2',
                'ailier' => '3',
                'ailier fort' => '4',
                'pivot' => '5'
            ];

            function groupJoueursByRole($joueurs) {
                $grouped = [];
                foreach ($joueurs as $joueur) {
                    $role = $joueur['role'];
                    if (!isset($grouped[$role])) {
                        $grouped[$role] = [];
                    }
                    $grouped[$role][] = $joueur;
                }
                return $grouped;
            }

            $joueurs_disponibles_grouped = groupJoueursByRole($joueurs_disponibles);
            $joueurs_selectionnes_grouped = groupJoueursByRole($joueurs_selectionnes);
            ?>

            <!-- Joueurs Disponibles -->
            <div class="available-players">
                <h4>Joueurs disponibles</h4>
                <form method="POST" action="<?= BASE_URL ?>matchs/ajouter-joueur">
                    <input type="hidden" name="id_match" value="<?= $match['id_rencontre'] ?>">
                    <?php foreach($roles as $role => $numero): ?>
                        <?php if (isset($joueurs_disponibles_grouped[$role])): ?>
                            <div class="role-section">
                                <h5><?= ucfirst($role) ?> (<?= $numero ?>)</h5>
                                <?php foreach($joueurs_disponibles_grouped[$role] as $joueur): ?>
                                    <div class="player-item">
                                        <label>
                                            <input type="checkbox" name="joueurs[]" value="<?= $joueur['id_joueur'] ?>">
                                            <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                                        </label>
                                        <select name="role_<?= $joueur['id_joueur'] ?>" class="role-select">
                                            <option value="titulaire">Titulaire</option>
                                            <option value="remplacant" selected>Remplaçant</option>
                                        </select>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <button type="submit" name="ajouter_joueur" class="btn btn-primary">Ajouter les joueurs</button>
                </form>
            </div>

            <!-- Joueurs Sélectionnés -->
            <div class="selected-players">
                <h4>Joueurs sélectionnés</h4>                 
                
                <!-- Titulaires -->
                <div class="titulaires">
                    <h5>Titulaires</h5>
                    <?php 
                    $titulaires = array_filter($joueurs_selectionnes, function($j) {
                        return $j['participation_role'] === 'Titulaire';
                    });
                    
                    foreach($titulaires as $joueur): ?>
                        <div class="player-item">
                            <div class="player-info">
                                <span class="player-name">
                                    <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                                </span>
                                <span class="player-role">
                                    (<?= ucfirst($joueur['role']) ?>)
                                </span>
                            </div>
                            <form method="POST" action="<?= BASE_URL ?>matchs/retirer-joueur" style="display: inline;">
                                <input type="hidden" name="id_joueur" value="<?= $joueur['id_joueur'] ?>">
                                <input type="hidden" name="id_match" value="<?= $match['id_rencontre'] ?>">
                                <button type="submit" class="btn btn-danger">Retirer</button>
                            </form>
                        </div>
                    <?php endforeach; ?>             
                </div>

                <!-- Remplaçants -->
                <div class="remplacants">
                    <h5>Remplaçants</h5>
                    <?php 
                    $remplacants = array_filter($joueurs_selectionnes, function($j) {
                        return $j['participation_role'] === 'Remplaçant';
                    });
                    
                    foreach($remplacants as $joueur): ?>
                        <div class="player-item">
                            <div class="player-info">
                                <span class="player-name">
                                    <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                                </span>
                                <span class="player-role">
                                    (<?= ucfirst($joueur['role']) ?>)
                                </span>
                            </div>
                            <form method="POST" action="<?= BASE_URL ?>matchs/retirer-joueur" style="display: inline;">
                                <input type="hidden" name="id_joueur" value="<?= $joueur['id_joueur'] ?>">
                                <input type="hidden" name="id_match" value="<?= $match['id_rencontre'] ?>">
                                <button type="submit" class="btn btn-danger">Retirer</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="<?= BASE_URL ?>matchs/liste" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>