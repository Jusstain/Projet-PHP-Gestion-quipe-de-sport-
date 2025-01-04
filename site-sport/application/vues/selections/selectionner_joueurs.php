<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sélectionner les Joueurs pour le Match</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
    <style>
        .selection-joueur {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .selection-joueur h4 {
            margin: 0 0 10px 0;
        }
    </style>
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Sélectionner les Joueurs pour le Match contre <?= htmlspecialchars($match['adversaire']) ?> le <?= htmlspecialchars($match['date_match']) ?></h2>
        <form action="" method="POST">
            <?php foreach($joueurs_actifs as $joueur): ?>
                <div class="selection-joueur">
                    <input type="checkbox" name="selections[<?= $joueur['id'] ?>][joueur_id]" value="<?= $joueur['id'] ?>">
                    <strong><?= htmlspecialchars($joueur['prenom']) ?> <?= htmlspecialchars($joueur['nom']) ?></strong><br>
                    Taille: <?= htmlspecialchars($joueur['taille']) ?> cm<br>
                    Poids: <?= htmlspecialchars($joueur['poids']) ?> kg<br>
                    Commentaires: <?= htmlspecialchars($joueur['commentaires']) ?><br>
                    <label>Rôle :</label>
                    <select name="selections[<?= $joueur['id'] ?>][role]">
                        <option value="Titulaire">Titulaire</option>
                        <option value="Remplaçant">Remplaçant</option>
                    </select><br>
                    <label>Poste :</label>
                    <input type="text" name="selections[<?= $joueur['id'] ?>][poste]" required>
                </div>
            <?php endforeach; ?>
            <button type="submit">Valider la Sélection</button>
        </form>
    </div>
</body>
</html>
