<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
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
        <h2>Statistiques</h2>

        <?php if (!empty($this->erreurs)): ?>
            <div class="erreurs">
                <?php foreach ($this->erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Statistiques des matchs -->
        <h3>Statistiques des matchs</h3>
        <div class="stats-container">
            <div class="stat-card">
                <h4>Victoires</h4>
                <p><?= $stats_matchs['victoires'] ?> (<?= $stats_matchs['pourcentage_victoires'] ?>%)</p>
            </div>
            <div class="stat-card">
                <h4>Défaites</h4>
                <p><?= $stats_matchs['defaites'] ?></p>
            </div>
            <div class="stat-card">
                <h4>Matchs nuls</h4>
                <p><?= $stats_matchs['nuls'] ?></p>
            </div>
        </div>

        <!-- Statistiques des joueurs -->
        <h3>Statistiques des joueurs</h3>
        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Statut</th>
                    <th>Poste préféré</th>
                    <th>Titularisations</th>
                    <th>Remplacements</th>
                    <th>Moyenne évaluations</th>
                    <th>Matchs consécutifs</th>
                    <th>% Victoires</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($stats_joueurs as $joueur): ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['nom']) ?> <?= htmlspecialchars($joueur['prenom']) ?></td>
                    <td><?= htmlspecialchars($joueur['statut']) ?></td>
                    <td><?= htmlspecialchars($joueur['poste_prefere']) ?></td>
                    <td><?= $joueur['nb_titularisations'] ?></td>
                    <td><?= $joueur['nb_remplacements'] ?></td>
                    <td><?= number_format($joueur['moyenne_evaluations'], 2) ?></td>
                    <td><?= $joueur['nb_matchs_consecutifs'] ?></td>
                    <td><?= number_format($joueur['pourcentage_victoires'], 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="<?= BASE_URL ?>joueurs/liste" class="btn">Retour à la liste des joueurs</a>
    </div>
</body>
</html>