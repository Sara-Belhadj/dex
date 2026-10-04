<?php
    const BD_HOTE = 'localhost';
    const BD_NOM = 'DexBD';
    const BD_UTILISATEUR = 'root';
    const BD_MOT_DE_PASSE = '';

    //les infos pour pouvoir se connecter a notre base de donnees
    $dsn = 'mysql:host=' . BD_HOTE . ';dbname=' . BD_NOM . ';charset=utf8mb4';
    

    // Les regles donnees au pdo. 
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // si ya une erruer
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // quest ce quil va retourner
        PDO::ATTR_EMULATE_PREPARES => false, // pour la manipulation des requetes genre si on select...
    ];

    try {
        // declaration du pdo dans une variable pour la connexion
        $pdo = new PDO($dsn, BD_UTILISATEUR, BD_MOT_DE_PASSE, $options);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        exit('Une erreur est survenue lors de la connexion à la base de données.');
    }

    // Creation de la table cours
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS cours (
            id VARCHAR(30) PRIMARY KEY,
            titre VARCHAR(100) NOT NULL
        )
    ");

    // Creation de la table travaux
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS travaux (
            id VARCHAR(30) PRIMARY KEY,
            cours_id VARCHAR(30) NOT NULL,
            titre VARCHAR(150) NOT NULL,
            description TEXT NOT NULL,
            type VARCHAR(20) NOT NULL,
            disponible DATE NOT NULL,
            remise DATETIME NOT NULL,
            ouvert BOOLEAN NOT NULL,
                
            FOREIGN KEY (cours_id) REFERENCES cours(id)
        )
    ");

    //Creation de la table 
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS creneaux (
            id VARCHAR(30) PRIMARY KEY,
            travail_id VARCHAR(30) NOT NULL,
            debut DATETIME NOT NULL,
            fin DATETIME NOT NULL,

            FOREIGN KEY (travail_id) REFERENCES travaux(id)
        )
    ");

    //Creation de la table 
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS disponibilites (
            id INT AUTO_INCREMENT PRIMARY KEY,
            travail_id VARCHAR(30) NOT NULL,
            creneau_id VARCHAR(30) NOT NULL,
            matricule VARCHAR(20) NOT NULL,
            nom VARCHAR(100) NOT NULL,

            FOREIGN KEY (travail_id) REFERENCES travaux(id),
            FOREIGN KEY (creneau_id) REFERENCES creneaux(id),

            UNIQUE (travail_id, creneau_id, matricule)
        )
    ");

    $cours = [
        ['420-244-AH', 'Bases de données applicatives'],
        ['420-245-AH', 'Programmation Web 1'],
        ['420-248-AH', 'Programmation Web 2'],
        ['420-253-AH', 'Projet de fin d’études']
    ];

    $travaux = [
        ['web1-tp1', '420-245-AH', 'TP1 — Catalogue de produits', 'Construire une première application PHP permettant d’afficher et de filtrer un catalogue.', 'individuel', '2026-09-01', '2026-09-20 23:59', 0],
        ['web2-tp1', '420-248-AH', 'TP1 — Gestion de réservations', 'Développer une application Web transactionnelle permettant d’enregistrer et de consulter des réservations.', 'equipe', '2026-09-21', '2026-10-18 23:59', 1],
        ['bdd-lab2', '420-244-AH', 'Laboratoire 2 — Requêtes SQL', 'Écrire et tester des requêtes SQL sur une base de données relationnelle fournie.', 'individuel', '2026-09-28', '2026-10-12 23:59', 1],
        ['bdd-tp1', '420-244-AH', 'TP1 — Modélisation d’une bibliothèque', 'Concevoir un modèle relationnel et produire le script SQL permettant de créer la base de données.', 'equipe', '2026-10-05', '2026-10-25 23:59', 1],
        ['pfe-prototype', '420-253-AH', 'Prototype fonctionnel', 'Produire une première version fonctionnelle du projet et préparer une démonstration à l’équipe enseignante.', 'equipe', '2026-09-15', '2026-10-09 23:59', 1]
    ];

    $creneaux = [
        ['web1-tp1', 'web1-tp1-01', '2026-09-15 18:00', '2026-09-15 19:30'],
        ['web1-tp1', 'web1-tp1-02', '2026-09-16 12:00', '2026-09-16 13:30'],
        ['web1-tp1', 'web1-tp1-03', '2026-09-17 17:00', '2026-09-17 18:30'],
        ['web2-tp1', 'web2-tp1-01', '2026-10-05 18:00', '2026-10-05 19:30'],
        ['web2-tp1', 'web2-tp1-02', '2026-10-06 12:00', '2026-10-06 13:30'],
        ['web2-tp1', 'web2-tp1-03', '2026-10-07 17:00', '2026-10-07 18:30'],
        ['bdd-lab2', 'bdd-lab2-01', '2026-10-01 16:00', '2026-10-01 17:30'],
        ['bdd-lab2', 'bdd-lab2-02', '2026-10-02 12:00', '2026-10-02 13:30'],
        ['bdd-lab2', 'bdd-lab2-03', '2026-10-04 10:00', '2026-10-04 11:30'],
        ['bdd-tp1', 'bdd-tp1-01', '2026-10-13 18:00', '2026-10-13 19:30'],
        ['bdd-tp1', 'bdd-tp1-02', '2026-10-14 12:00', '2026-10-14 13:30'],
        ['bdd-tp1', 'bdd-tp1-03', '2026-10-15 17:00', '2026-10-15 18:30'],
        ['pfe-prototype', 'int-s1-01', '2026-09-29 18:00', '2026-09-29 20:00'],
        ['pfe-prototype', 'int-s1-02', '2026-09-30 17:00', '2026-09-30 19:00'],
        ['pfe-prototype', 'int-s1-03', '2026-10-01 18:00', '2026-10-01 20:00']
    ];

?>
