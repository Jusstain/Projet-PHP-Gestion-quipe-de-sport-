<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <?php if(isset($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="nom_utilisateur" required><br>

            <label>Mot de passe :</label>
            <input type="password" name="mot_de_passe" required><br>

            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="inscription.php">Inscription</a></p>
    </div>
</body>
</html>
