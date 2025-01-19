<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection des Joueurs</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
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
            <!-- Joueurs Disponibles -->
            <div class="available-players">
                <h4>Joueurs disponibles</h4>
                <form method="POST">
                    <input type="hidden" name="id_match" value="<?= $match['id_rencontre'] ?>">
                    <?php foreach($joueurs_disponibles as $joueur): ?>
                        <div class="player-item">
                            <label>
                                <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                                <select name="joueurs[<?= $joueur['id_joueur'] ?>]">
                                    <option value="">Sélectionner un poste</option>
                                    <option value="pivot">Pivot</option>
                                    <option value="ailier">Ailier</option>
                                    <option value="arriere">Arrière</option>
                                    <option value="meneur">Meneur</option>
                                </select>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" name="ajouter_joueurs" class="btn btn-primary">Ajouter les joueurs</button>
                </form>
            </div>

            <!-- Joueurs Sélectionnés -->
            <div class="selected-players">
                <h4>Joueurs sélectionnés</h4>
                <?php foreach($joueurs_selectionnes as $joueur): ?>
                    <div class="player-item">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="retirer_joueur" value="<?= $joueur['id_joueur'] ?>">
                            <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?> 
                            (<?= htmlspecialchars($joueur['poste']) ?>)
                            <button type="submit" class="btn btn-danger">Retirer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="buttons">
            <a href="<?= BASE_URL ?>matchs/liste" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>