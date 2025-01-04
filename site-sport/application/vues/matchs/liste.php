<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Matchs</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Liste des Matchs</h2>
        <a href="<?= BASE_URL ?>matchs/ajouter.php" class="btn">Ajouter un Match</a>
        <table>
            <thead>
                <tr>
                    <th>Date et Heure</th>
                    <th>Adversaire</th>
                    <th>Lieu</th>
                    <th>Résultat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($matchs as $match): ?>
                    <tr>
                        <td><?= htmlspecialchars($match['date_match']) ?></td>
                        <td><?= htmlspecialchars($match['adversaire']) ?></td>
                        <td><?= htmlspecialchars($match['lieu']) ?></td>
                        <td><?= htmlspecialchars($match['resultat'] ?? 'En attente') ?></td>
                        <td>
                            <a href="modifier.php?id=<?= $match['id'] ?>">Modifier</a> |
                            <a href="supprimer.php?id=<?= $match['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce match ?');">Supprimer</a> |
                            <a href="<?= BASE_URL ?>selections/selectionner_joueurs.php?match_id=<?= $match['id'] ?>">Sélectionner Joueurs</a> |
                            <a href="evaluer.php?id=<?= $match['id'] ?>">Évaluer le Match</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
