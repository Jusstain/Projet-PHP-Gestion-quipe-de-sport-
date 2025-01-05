<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluer les Joueurs</title>
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
        <h2>Évaluation - Match contre <?= htmlspecialchars($match['equipe_adverse']) ?></h2>
        
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
                <label for="resultat">Résultat du match :</label>
                <select id="resultat" name="resultat" required>
                    <option value="">Sélectionner...</option>
                    <option value="Victoire">Victoire</option>
                    <option value="Défaite">Défaite</option>
                    <option value="Nul">Match nul</option>
                </select>
            </div>

            <h3>Évaluation des joueurs</h3>
            
            <?php foreach($joueurs_selectionnes as $joueur): ?>
            <div class="evaluation-joueur">
                <h4><?= htmlspecialchars($joueur['prenom']) ?> <?= htmlspecialchars($joueur['nom']) ?></h4>
                <p>Poste : <?= htmlspecialchars($joueur['poste']) ?></p>
                <p>Rôle : <?= htmlspecialchars($joueur['role']) ?></p>
                
                <div class="form-group">
                    <label>Note (1-5) :</label>
                    <select name="evaluations[<?= $joueur['id_joueur'] ?>]" required>
                        <option value="">Choisir...</option>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <?php endforeach; ?>

            <button type="submit" class="btn-submit">Valider les évaluations</button>
        </form>
        
        <a href="<?= BASE_URL ?>matchs/liste" class="btn">Retour à la liste</a>
    </div>
</body>
</html>