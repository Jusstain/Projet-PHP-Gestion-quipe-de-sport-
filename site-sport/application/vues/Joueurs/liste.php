<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
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
        <h2>Liste des Joueurs</h2>
        
        <?php if (!empty($this->erreurs)): ?>
            <div class="erreurs">
                <?php foreach ($this->erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <a href="<?= BASE_URL ?>joueurs/ajouter" class="btn">Ajouter un joueur</a>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>N° Licence</th>
                    <th>Date de naissance</th>
                    <th>Taille</th>
                    <th>Poids</th>
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
                    <td><?= htmlspecialchars($joueur['taille']) ?> m</td>
                    <td><?= htmlspecialchars($joueur['poids']) ?> kg</td>
                    <td><?= htmlspecialchars($joueur['statut']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>joueurs/modifier?id=<?= $joueur['id_joueur'] ?>">Modifier</a>
                        <a href="<?= BASE_URL ?>joueurs/supprimer?id=<?= $joueur['id_joueur'] ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>