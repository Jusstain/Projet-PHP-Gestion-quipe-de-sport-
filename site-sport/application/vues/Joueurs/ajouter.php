<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Joueur</title>
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
        <h2>Ajouter un Joueur</h2>
        
        <?php if (!empty($this->erreurs)): ?>
            <div class="erreurs">
                <?php foreach ($this->erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="form-container">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="id_joueur" value="<?= $joueur['id_joueur'] ?>">
            
            <div class="form-group">
                <label for="numero_licence">Numéro de licence:</label>
                <input type="text" id="numero_licence" name="numero_licence" 
                       value="<?= htmlspecialchars($joueur['numero_licence'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" 
                       value="<?= htmlspecialchars($joueur['nom'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            
            <div class="form-group">
                <label for="date_naissance">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>

            <div class="form-group">
                <label for="taille">Taille (m):</label>
                <input type="number" id="taille" name="taille" step="0.01" min="1.00" max="2.50" required>
            </div>

            <div class="form-group">
                <label for="poids">Poids (kg):</label>
                <input type="number" id="poids" name="poids" step="0.1" min="40" max="150" required>
            </div>

            <div class="form-group">
                <label for="role">Poste:</label>
                <select name="role" id="role" required>
                    <option value="">Sélectionner un poste</option>
                    <option value="meneur">Meneur</option>
                    <option value="arriere">Arrière</option>
                    <option value="ailier">Ailier</option>
                    <option value="ailier fort">Ailier Fort</option>
                    <option value="pivot">Pivot</option>
                </select>
            </div>

            <div class="form-group">
                <label for="statut">Statut:</label>
                <select id="statut" name="statut" required>
                    <option value="Actif" selected>Actif</option>
                    <option value="Blessé">Blessé</option>
                    <option value="Suspendu">Suspendu</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="commentaire">Commentaire:</label>
                <textarea id="commentaire" name="commentaire" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="<?= BASE_URL ?>joueurs/liste" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>