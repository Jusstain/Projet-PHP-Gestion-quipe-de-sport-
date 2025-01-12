<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
        <h2>Connexion</h2>
        
        <form method="POST" action="<?= BASE_URL ?>connexion" class="form-container">
            <?php if (!empty($erreurs)): ?>
                <div class="erreurs">
                    <?php foreach ($erreurs as $erreur): ?>
                        <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="form-group">
                <label for="username">Identifiant :</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>
</body>
</html>