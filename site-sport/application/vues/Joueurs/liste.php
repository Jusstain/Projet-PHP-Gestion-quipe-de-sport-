<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Liste des Joueurs</h2>
        <a href="<?= BASE_URL ?>joueurs/ajouter.php" class="btn">Ajouter un Joueur</a>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de Licence</th>
                    <th>Date de Naissance</th>
                    <th>Taille (cm)</th>
                    <th>Poids (kg)</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($joueurs as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['nom']) ?></td>
                        <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                        <td><?= htmlspecialchars($joueur['numero_licence']) ?></td>
                        <td><?= htmlspecialchars($joueur['date_naissance']) ?></td>
                        <td><?= htmlspecialchars($joueur['taille']) ?></td>
                        <td><?= htmlspecialchars($joueur['poids']) ?></td>
                        <td><?= htmlspecialchars($joueur['statut']) ?></td>
                        <td>
                            <a href="modifier.php?id=<?= $joueur['id'] ?>">Modifier</a> |
                            <a href="supprimer.php?id=<?= $joueur['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
