<?php

const BD_HOME = 'localhost';
const BD_NOM = 'dexbd';
const BD_UTILISATEUR = 'root';
const BD_MOT_DE_PASSE = '';

$dns = 'mysql:host=' . BD_HOME . ';dbname=' . BD_NOM . ';charset=utf8mb4';


$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dns, BD_UTILISATEUR, BD_MOT_DE_PASSE, $options);
} catch (PDOException $e) {
    http_response_code(500);

    exit('Connexion à la base de données impossible.');
}

?>