<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Match</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Modifier un Match</h2>
        <?php if(isset($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Date et Heure :</label>
            <input type="datetime-local" name="date_match" value="<?= htmlspecialchars($match['date_match']) ?>" required><br>

            <label>Adversaire :</label>
            <input type="text" name="adversaire" value="<?= htmlspecialchars($match['adversaire']) ?>" required><br>

            <label>Lieu :</label>
            <select name="lieu" required>
                <option value="Domicile" <?= $match['lieu'] == 'Domicile' ? 'selected' : '' ?>>Domicile</option>
                <option value="Extérieur" <?= $match['lieu'] == 'Extérieur' ? 'selected' : '' ?>>Extérieur</option>
            </select><br>

            <label>Résultat :</label>
            <input type="text" name="resultat" value="<?= htmlspecialchars($match['resultat']) ?>"><br>

            <button type="submit">Mettre à Jour</button>
        </form>
    </div>
</body>
</html>
