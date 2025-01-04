<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Joueur</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Ajouter un Joueur</h2>
        <?php if(isset($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Prénom :</label>
            <input type="text" name="prenom" required><br>

            <label>Nom :</label>
            <input type="text" name="nom" required><br>

            <label>Numéro de Licence :</label>
            <input type="text" name="numero_licence" required><br>

            <label>Date de Naissance :</label>
            <input type="date" name="date_naissance" required><br>

            <label>Taille (cm) :</label>
            <input type="number" name="taille" step="0.1" required><br>

            <label>Poids (kg) :</label>
            <input type="number" name="poids" step="0.1" required><br>

            <label>Statut :</label>
            <select name="statut" required>
                <option value="Actif">Actif</option>
                <option value="Blessé">Blessé</option>
                <option value="Suspendu">Suspendu</option>
                <option value="Absent">Absent</option>
            </select><br>

            <label>Commentaires :</label>
            <textarea name="commentaires"></textarea><br>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
