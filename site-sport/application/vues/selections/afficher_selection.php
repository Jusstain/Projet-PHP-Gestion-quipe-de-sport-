<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher la Sélection des Joueurs</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Sélection des Joueurs pour le Match contre <?= htmlspecialchars($match['adversaire']) ?> le <?= htmlspecialchars($match['date_match']) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($selections as $selection): ?>
                    <tr>
                        <td><?= htmlspecialchars($selection['nom']) ?></td>
                        <td><?= htmlspecialchars($selection['prenom']) ?></td>
                        <td><?= htmlspecialchars($selection['role']) ?></td>
                        <td><?= htmlspecialchars($selection['poste']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
