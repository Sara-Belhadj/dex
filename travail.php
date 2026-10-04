<!-- Je comprends pas cette partie -->
<?php
    require __DIR__ . '/includes/db.php';
    $travailId = $_GET['travail'] ?? '';

    $request = $pdo->prepare("
        SELECT travaux.*, cours.titre AS cours_titre
        FROM travaux
        JOIN cours ON travaux.cours_id = cours.id
        WHERE travaux.id = ?
    ");

    $request->execute([$travailId]);
    $travail = $request->fetch();

    if (!$travail) {
        header('Location: index.php', true, 303);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dex</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/icon.png">
</head>
<body>
    <div class="glass-container">
        <div class="header">
            <header>
                <div class="logo">
                    <img src= "images/icon.png" alt="Logo">
                    <h1>Dex</h1>
                </div>
            </header>

            <h1 class="titre">Travaux ouverts</h1>
            <div class="desc-list">
                <p class="description">Choisis un travail et trouve le meilleur moment pour étudier ensemble.<p>
                <div class="list">
                    <select name="course" id="course-list">
                        <option value="">Tous les cours</option>
                        <option value="420-244-AH">Bases de données applicatives</option>                        ¸
                        <option value="420-245-AH">Programmation Web 1</option>
                        <option value="420-248-AH">Programmation Web 2</option>
                        <option value="420-253-AH">Projet de fin d’études</option>
                    </select>

                    <button>Filtrer</button>
                </div>
            </div>
            <main class="glass-container2">
                <h1><?= htmlspecialchars($travail['titre']) ?></h1>
                <p><?= htmlspecialchars($travail['cours_titre']) ?></p>
                <p><?= htmlspecialchars($travail['description']) ?></p>
                <p>Type : <?= htmlspecialchars($travail['type']) ?></p>
                <p>Disponible : <?= htmlspecialchars($travail['disponible']) ?></p>
                <p>Remise : <?= htmlspecialchars($travail['remise']) ?></p>
            </main>
        </div>
    </div>
</body>
</html>