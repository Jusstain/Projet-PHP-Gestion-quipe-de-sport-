<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluer le Match</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
    <style>
        .evaluation-joueur {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Évaluer le Match contre <?= htmlspecialchars($match['adversaire']) ?> le <?= htmlspecialchars($match['date_match']) ?></h2>
        <form action="" method="POST">
            <label>Résultat :</label>
            <select name="resultat" required>
                <option value="Victoire" <?= $match['resultat'] == 'Victoire' ? 'selected' : '' ?>>Victoire</option>
                <option value="Défaite" <?= $match['resultat'] == 'Défaite' ? 'selected' : '' ?>>Défaite</option>
                <option value="Nul" <?= $match['resultat'] == 'Nul' ? 'selected' : '' ?>>Nul</option>
            </select><br><br>

            <h3>Évaluations des Joueurs</h3>
            <?php foreach($joueurs_selectionnes as $joueur): ?>
                <div class="evaluation-joueur">
                    <strong><?= htmlspecialchars($joueur['prenom']) ?> <?= htmlspecialchars($joueur['nom']) ?></strong><br>
                    <label>Note de Performance (1-5) :</label>
                    <select name="notes[<?= $joueur['joueur_id'] ?>]" required>
                        <option value="1" <?= (isset($_POST['notes'][$joueur['joueur_id']]) && $_POST['notes'][$joueur['joueur_id']] == 1) ? 'selected' : '' ?>>1</option>
                        <option value="2" <?= (isset($_POST['notes'][$joueur['joueur_id']]) && $_POST['notes'][$joueur['joueur_id']] == 2) ? 'selected' : '' ?>>2</option>
                        <option value="3" <?= (isset($_POST['notes'][$joueur['joueur_id']]) && $_POST['notes'][$joueur['joueur_id']] == 3) ? 'selected' : '' ?>>3</option>
                        <option value="4" <?= (isset($_POST['notes'][$joueur['joueur_id']]) && $_POST['notes'][$joueur['joueur_id']] == 4) ? 'selected' : '' ?>>4</option>
                        <option value="5" <?= (isset($_POST['notes'][$joueur['joueur_id']]) && $_POST['notes'][$joueur['joueur_id']] == 5) ? 'selected' : '' ?>>5</option>
                    </select><br>

                    <label>Système d'Étoiles (1-5) :</label>
                    <select name="etoiles[<?= $joueur['joueur_id'] ?>]" required>
                        <option value="1" <?= (isset($_POST['etoiles'][$joueur['joueur_id']]) && $_POST['etoiles'][$joueur['joueur_id']] == 1) ? 'selected' : '' ?>>1</option>
                        <option value="2" <?= (isset($_POST['etoiles'][$joueur['joueur_id']]) && $_POST['etoiles'][$joueur['joueur_id']] == 2) ? 'selected' : '' ?>>2</option>
                        <option value="3" <?= (isset($_POST['etoiles'][$joueur['joueur_id']]) && $_POST['etoiles'][$joueur['joueur_id']] == 3) ? 'selected' : '' ?>>3</option>
                        <option value="4" <?= (isset($_POST['etoiles'][$joueur['joueur_id']]) && $_POST['etoiles'][$joueur['joueur_id']] == 4) ? 'selected' : '' ?>>4</option>
                        <option value="5" <?= (isset($_POST['etoiles'][$joueur['joueur_id']]) && $_POST['etoiles'][$joueur['joueur_id']] == 5) ? 'selected' : '' ?>>5</option>
                    </select>
                </div>
            <?php endforeach; ?>

            <button type="submit">Valider les Évaluations</button>
        </form>
    </div>
</body>
</html>
