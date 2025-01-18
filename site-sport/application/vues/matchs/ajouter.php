<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Match</title>
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
        <h2>Ajouter un Match</h2>
        
        <?php if (!empty($this->erreurs)): ?>
            <div class="erreurs">
                <?php foreach ($this->erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="form-group">
                <label for="date_heure">Date et heure :</label>
                <input type="datetime-local" id="date_heure" name="date_heure" required>
            </div>

            <div class="form-group">
                <label for="equipe_adverse">Équipe adverse :</label>
                <input type="text" id="equipe_adverse" name="equipe_adverse" required>
            </div>

            <div class="form-group">
                <label for="lieu">Lieu :</label>
                <select id="lieu" name="lieu" required>
                    <option value="Domicile">Domicile</option>
                    <option value="Extérieur">Extérieur</option>
                </select>
            </div>

            <div class="form-group">
                <label for="numero_licence">Numéro de Licence (8 chiffres max):</label>
                <input type="text" id="numero_licence" name="numero_licence" maxlength="8" pattern="^\d{8}$" required>
                <small>Le numéro de licence doit être composé de 8 chiffres.</small>
            </div>

            <button type="submit" class="btn-submit">Ajouter le match</button>
        </form>
        
        <a href="<?= BASE_URL ?>matchs/liste" class="btn">Retour à la liste</a>
    </div>
</body>
</html>
