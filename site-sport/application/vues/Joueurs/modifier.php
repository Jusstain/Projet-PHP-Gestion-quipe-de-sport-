<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Joueur</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Modifier un Joueur</h2>
        <?php if(isset($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($joueur['prenom']) ?>" required><br>

            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($joueur['nom']) ?>" required><br>

            <label>Numéro de Licence :</label>
            <input type="text" name="numero_licence" value="<?= htmlspecialchars($joueur['numero_licence']) ?>" required><br>

            <label>Date de Naissance :</label>
            <input type="date" name="date_naissance" value="<?= htmlspecialchars($joueur['date_naissance']) ?>" required><br>

            <label>Taille (cm) :</label>
            <input type="number" name="taille" step="0.1" value="<?= htmlspecialchars($joueur['taille']) ?>" required><br>

            <label>Poids (kg) :</label>
            <input type="number" name="poids" step="0.1" value="<?= htmlspecialchars($joueur['poids']) ?>" required><br>

            <label>Statut :</label>
            <select name="statut" required>
                <option value="Actif" <?= $joueur['statut'] == 'Actif' ? 'selected' : '' ?>>Actif</option>
                <option value="Blessé" <?= $joueur['statut'] == 'Blessé' ? 'selected' : '' ?>>Blessé</option>
                <option value="Suspendu" <?= $joueur['statut'] == 'Suspendu' ? 'selected' : '' ?>>Suspendu</option>
                <option value="Absent" <?= $joueur['statut'] == 'Absent' ? 'selected' : '' ?>>Absent</option>
            </select><br>

            <label>Commentaires :</label>
            <textarea name="commentaires"><?= htmlspecialchars($joueur['commentaires']) ?></textarea><br>

            <button type="submit">Mettre à Jour</button>
        </form>
    </div>
</body>
</html>
