<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        <h2>Matchs à venir</h2>
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
                <?php foreach($matchs_a_venir as $match): ?>
                <tr>
                    <td><?= htmlspecialchars($match['date_heure']) ?></td>
                    <td><?= htmlspecialchars($match['equipe_adverse']) ?></td>
                    <td><?= htmlspecialchars($match['lieu']) ?></td>
                    <td>
                        <form method="POST" action="<?= BASE_URL ?>matchs/resultat" class="result-form">
                            <input type="hidden" name="id_match" value="<?= $match['id_rencontre'] ?>">
                            <select name="resultat" class="select-resultat">
                                <option value="">-- Résultat --</option>
                                <option value="victoire">Victoire</option>
                                <option value="defaite">Défaite</option>
                                <option value="nul">Nul</option>
                            </select>
                            <button type="submit" class="btn-resultat">Valider</button>
                        </form>
                    </td>
                    <td class="actions">
                        <a href="<?= BASE_URL ?>matchs/selection?id=<?= $match['id_rencontre'] ?>" 
                           class="btn-select">Sélectionner joueurs</a>
                        <a href="<?= BASE_URL ?>matchs/supprimer?id=<?= $match['id_rencontre'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce match ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Matchs passés</h2>
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
                <?php foreach($matchs_passes as $match): ?>
                <tr>
                    <td><?= htmlspecialchars($match['date_heure']) ?></td>
                    <td><?= htmlspecialchars($match['equipe_adverse']) ?></td>
                    <td><?= htmlspecialchars($match['lieu']) ?></td>
                    <td><?= ucfirst($match['resultat']) ?></td>
                    <td class="actions">
                        <a href="<?= BASE_URL ?>matchs/evaluer?id=<?= $match['id_rencontre'] ?>" 
                           class="btn-evaluate">Évaluer</a>
                        <a href="<?= BASE_URL ?>matchs/supprimer?id=<?= $match['id_rencontre'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce match ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>