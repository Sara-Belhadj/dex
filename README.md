# Dex

Dex est une application qui permet aux étudiants de partager leurs disponibilités pour organiser des rencontres de travail.

## Installation

1. Placer le projet dans le dossier `htdocs`.
2. Démarrer Apache et MySQL avec XAMPP.
3. Créer une base de données nommée `DexBD`.
4. Ouvrir `init.php` dans le navigateur pour créer les tables et ajouter les données initiales.
5. Ouvrir `index.php`.

## Utilisation

La page d'accueil affiche les travaux ouverts et permet de les filtrer par cours.

Pour ajouter ses disponibilités, il faut ouvrir un travail, entrer son matricule et son nom, puis sélectionner un ou plusieurs créneaux.

Une nouvelle soumission avec le même matricule remplace les anciennes disponibilités pour ce travail.