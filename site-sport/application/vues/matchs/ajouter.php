<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Match</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Ajouter un Match</h2>
        <?php if(isset($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Date et Heure :</label>
            <input type="datetime-local" name="date_match" required><br>

            <label>Adversaire :</label>
            <input type="text" name="adversaire" required><br>

            <label>Lieu :</label>
            <select name="lieu" required>
                <option value="Domicile">Domicile</option>
                <option value="Extérieur">Extérieur</option>
            </select><br>

            <label>Résultat :</label>
            <input type="text" name="resultat" placeholder="e.g., Victoire, Défaite, Nul"><br>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
