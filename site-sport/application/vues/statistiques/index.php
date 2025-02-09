<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <p>Nombre : <?= isset($stats_matchs['victoires']) ? $stats_matchs['victoires'] : 0 ?></p>
                <p>Pourcentage : <?= isset($stats_matchs['victoires']) ? number_format($stats_matchs['pourcentage_victoires'], 2) : 0 ?>%</p>
            </div>
            <div class="stat-card">
                <h4>Défaites</h4>
                <p>Nombre : <?= isset($stats_matchs['defaites']) ? $stats_matchs['defaites'] : 0 ?></p>
                <p>Pourcentage : <?= isset($stats_matchs['defaites']) ? number_format($stats_matchs['pourcentage_defaites'], 2) : 0 ?>%</p>
            </div>
            <div class="stat-card">
                <h4>Matchs nuls</h4>
                <p>Nombre : <?= isset($stats_matchs['nuls']) ? $stats_matchs['nuls'] : 0 ?></p>
                <p>Pourcentage : <?= isset($stats_matchs['nuls']) ? number_format($stats_matchs['pourcentage_nuls'], 2) : 0 ?>%</p>
            </div>
        </div>

        <a href="<?= BASE_URL ?>joueurs/liste" class="btn">Retour à la liste des joueurs</a>
    </div>
</body>
</html>
