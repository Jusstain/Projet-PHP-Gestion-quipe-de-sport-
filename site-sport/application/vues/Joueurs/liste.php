<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
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
                    <th>Date de naissance</th>
                    <th>Taille (m)</th>
                    <th>Poids (kg)</th>
                    <th>Poste</th>
                    <th>Statut</th>
                    <th>Commentaires</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($joueurs as $joueur): ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['nom']) ?></td>
                    <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                    <td><?= htmlspecialchars($joueur['date_naissance']) ?></td>
                    <td><?= number_format((float)$joueur['taille'], 2) ?></td>
                    <td><?= number_format((float)$joueur['poids'], 1) ?></td>
                    <td><?= ucfirst($joueur['role']) ?></td>
                    <td><?= htmlspecialchars($joueur['statut']) ?></td>
                    <td><?= !empty($joueur['commentaire']) ? htmlspecialchars($joueur['commentaire']) : 'Aucun commentaire pour ce joueur' ?></td>
                    <td class="actions">
                        <a href="<?= BASE_URL ?>joueurs/modifier?id=<?= $joueur['id_joueur'] ?>" class="btn btn-edit">Modifier</a>
                        <a href="<?= BASE_URL ?>joueurs/supprimer?id=<?= $joueur['id_joueur'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>