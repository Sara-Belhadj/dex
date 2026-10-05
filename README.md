# Dex

Application Web permettant de coordonner les disponibilités des étudiants pour les travaux.

## Installation

1. Placer le projet dans le dossier `htdocs` de XAMPP.
2. Démarrer Apache et MySQL.
3. Créer une base de données nommée `DexBD` dans phpMyAdmin.
4. Ouvrir `init.php` dans le navigateur pour créer les tables et ajouter les données initiales.
5. Ouvrir `index.php`.

## Utilisation

La page d'accueil affiche les travaux ouverts et permet de les filtrer par cours.

Pour un travail, un étudiant peut entrer son matricule et son nom, puis sélectionner ses disponibilités parmi les créneaux proposés.

Si le même matricule soumet de nouvelles disponibilités pour un travail, les anciennes sont remplacées.