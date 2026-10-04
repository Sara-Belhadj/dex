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
?>
