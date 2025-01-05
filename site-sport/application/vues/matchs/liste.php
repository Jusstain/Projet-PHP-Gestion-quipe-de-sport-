<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Matchs</title>
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
        <h2>Liste des Matchs</h2>
        <a href="<?= BASE_URL ?>matchs/ajouter" class="btn">Ajouter un match</a>
        
        <?php if (!empty($this->erreurs)): ?>
            <div class="erreurs">
                <?php foreach ($this->erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Équipe adverse</th>
                    <th>Lieu</th>
                    <th>Résultat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($matchs as $match): ?>
                <tr>
                    <td><?= htmlspecialchars($match['date_heure']) ?></td>
                    <td><?= htmlspecialchars($match['equipe_adverse']) ?></td>
                    <td><?= htmlspecialchars($match['lieu']) ?></td>
                    <td><?= htmlspecialchars($match['resultat'] ?? 'Non joué') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>matchs/selection?id=<?= $match['id_rencontre'] ?>">Sélectionner joueurs</a>
                        <a href="<?= BASE_URL ?>matchs/evaluer?id=<?= $match['id_rencontre'] ?>">Évaluer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>