<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if(isset($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="nom_utilisateur" required><br>

            <label>Mot de passe :</label>
            <input type="password" name="mot_de_passe" required><br>

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirmer_mot_de_passe" required><br>

            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="connexion.php">Connexion</a></p>
    </div>
</body>
</html>
