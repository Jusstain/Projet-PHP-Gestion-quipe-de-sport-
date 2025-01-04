# Site Sport

**Application de Gestion d'Équipe Sportive en PHP MVC**

## Description

Site Sport est une application web permettant de gérer les joueurs, les matchs, les sélections pour les matchs, et d'analyser les performances de l'équipe et des joueurs.

## Fonctionnalités

- **Authentification :**
  - Inscription des utilisateurs
  - Connexion et déconnexion sécurisées

- **Gestion des Joueurs :**
  - Ajouter, modifier, supprimer des joueurs
  - Visualiser la liste des joueurs

- **Gestion des Matchs :**
  - Ajouter, modifier, supprimer des matchs
  - Visualiser la liste des matchs

- **Sélection des Joueurs :**
  - Sélectionner les joueurs pour un match spécifique

- **Évaluation Post-Match :**
  - Saisir le résultat du match
  - Évaluer les performances des joueurs

- **Statistiques :**
  - Analyser les victoires, défaites, et nuls
  - Voir les statistiques individuelles des joueurs

## Installation

1. **Cloner le Dépôt :**

    ```bash
    git clone https://github.com/votre_nom/site-sport.git
    ```

2. **Naviguer dans le Répertoire :**

    ```bash
    cd site-sport
    ```

3. **Installer les Dépendances avec Composer :**

    ```bash
    composer install
    ```

4. **Configurer la Base de Données :**

    - Créez une base de données MySQL nommée `gestion_equipe_sportive`.
    - Importez le script SQL pour créer les tables nécessaires.

5. **Configurer les Paramètres de Connexion :**

    - Modifiez le fichier `/configuration/database.php` avec vos informations de connexion MySQL.

6. **Configurer le Serveur Web :**

    - Assurez-vous que le dossier `/public` est le répertoire racine de votre serveur web.
    - Activez le module `mod_rewrite` d'Apache pour le routage.

7. **Accéder à l'Application :**

    - Ouvrez votre navigateur et accédez à `http://localhost/site-sport/public/`.

## Utilisation

1. **Inscription :**
   - Accédez à la page d'inscription pour créer un compte utilisateur.

2. **Connexion :**
   - Connectez-vous avec vos identifiants pour accéder aux fonctionnalités de gestion.

3. **Gestion des Joueurs :**
   - Ajoutez de nouveaux joueurs, modifiez leurs informations ou supprimez-les si nécessaire.

4. **Gestion des Matchs :**
   - Programmez de nouveaux matchs, mettez à jour les détails ou annulez des matchs.

5. **Sélection des Joueurs :**
   - Sélectionnez les joueurs qui participeront à chaque match.

6. **Évaluation Post-Match :**
   - Après chaque match, saisissez le résultat et évaluez les performances des joueurs.

7. **Visualisation des Statistiques :**
   - Consultez les statistiques globales de l'équipe et les performances individuelles des joueurs.

## Tests

Les tests unitaires sont réalisés avec PHPUnit.

1. **Exécuter les Tests :**

    ```bash
    vendor/bin/phpunit
    ```

## Sécurité

- Utilisation de requêtes préparées avec PDO pour prévenir les injections SQL.
- Hashage des mots de passe avec `password_hash()`.
- Gestion sécurisée des sessions avec des paramètres `HttpOnly` et `Secure`.

## Contributions

Les contributions sont les bienvenues. Veuillez soumettre une pull request ou ouvrir une issue pour toute suggestion ou amélioration.

## Licence

Ce projet est sous licence MIT.
