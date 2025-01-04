<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <?php include '../application/vues/partials/header.php'; ?>

    <div class="container">
        <h2>Statistiques des Matchs</h2>
        <table>
            <thead>
                <tr>
                    <th>Victoires</th>
                    <th>Défaites</th>
                    <th>Nuls</th>
                    <th>Total de Matchs</th>
                    <th>% Victoires</th>
                    <th>% Défaites</th>
                    <th>% Nuls</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($statistiques_matchs['victoires']) ?></td>
                    <td><?= htmlspecialchars($statistiques_matchs['defaites']) ?></td>
                    <td><?= htmlspecialchars($statistiques_matchs['nuls']) ?></td>
                    <td><?= htmlspecialchars($statistiques_matchs['total_matchs']) ?></td>
                    <td><?= $statistiques_matchs['total_matchs'] > 0 ? round(($statistiques_matchs['victoires'] / $statistiques_matchs['total_matchs']) * 100, 2) : 0 ?>%</td>
                    <td><?= $statistiques_matchs['total_matchs'] > 0 ? round(($statistiques_matchs['defaites'] / $statistiques_matchs['total_matchs']) * 100, 2) : 0 ?>%</td>
                    <td><?= $statistiques_matchs['total_matchs'] > 0 ? round(($statistiques_matchs['nuls'] / $statistiques_matchs['total_matchs']) * 100, 2) : 0 ?>%</td>
                </tr>
            </tbody>
        </table>

        <h2>Statistiques des Joueurs</h2>
        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Statut</th>
                    <th>Poste Préféré</th>
                    <th>Titularisations</th>
                    <th>Remplacements</th>
                    <th>Moyenne des Notes</th>
                    <th>% Matchs Gagnés</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($statistiques_joueurs as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['prenom']) ?> <?= htmlspecialchars($joueur['nom']) ?></td>
                        <td><?= htmlspecialchars($joueur['statut']) ?></td>
                        <td><?= htmlspecialchars($joueur['poste_prefere']) ?></td>
                        <td><?= htmlspecialchars($joueur['total_titularisations']) ?></td>
                        <td><?= htmlspecialchars($joueur['total_remplacements']) ?></td>
                        <td><?= htmlspecialchars(number_format($joueur['moyenne_notes'], 2)) ?></td>
                        <td><?= htmlspecialchars(number_format($joueur['pourcentage_victoires'], 2)) ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
