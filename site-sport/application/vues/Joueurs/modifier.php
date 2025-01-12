<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Joueur</title>
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
        <h2>Modifier un Joueur</h2>
        
        <?php if (!empty($this->erreurs)): ?>
            <div class="erreurs">
                <?php foreach ($this->erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="form-container">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($joueur['nom']) ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($joueur['prenom']) ?>" required>
            </div>

            <div class="form-group">
                <label for="numero_licence">Numéro de licence :</label>
                <input type="text" id="numero_licence" name="numero_licence" value="<?= htmlspecialchars($joueur['numero_licence']) ?>" required>
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($joueur['date_naissance']) ?>" required>
            </div>

            <div class="form-group">
                <label for="taille">Taille (m) :</label>
                <input type="number" id="taille" name="taille" step="0.01" value="<?= htmlspecialchars($joueur['taille']) ?>" required>
            </div>

            <div class="form-group">
                <label for="poids">Poids (kg) :</label>
                <input type="number" id="poids" name="poids" value="<?= htmlspecialchars($joueur['poids']) ?>" required>
            </div>

            <div class="form-group">
                <label for="statut">Statut :</label>
                <select id="statut" name="statut" required>
                    <option value="Actif" <?= $joueur['statut'] === 'Actif' ? 'selected' : '' ?>>Actif</option>
                    <option value="Blessé" <?= $joueur['statut'] === 'Blessé' ? 'selected' : '' ?>>Blessé</option>
                    <option value="Suspendu" <?= $joueur['statut'] === 'Suspendu' ? 'selected' : '' ?>>Suspendu</option>
                    <option value="Absent" <?= $joueur['statut'] === 'Absent' ? 'selected' : '' ?>>Absent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire" rows="4"><?= htmlspecialchars($joueur['commentaire']) ?></textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="<?= BASE_URL ?>joueurs/liste" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>