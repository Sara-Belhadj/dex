<?php
$titre = $titrePage ?? 'Dex';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/icon.png">
</head>

<body>
    <header>
        <div class="logo">
            <img src="images/icon.png" alt="Logo">
            <h1><a href="index.php">Dex</a></h1>
        </div>
    </header>