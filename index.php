<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require __DIR__ . '/includes/db.php';
        $titrePage = 'Travaux ouverts';
        require __DIR__ . '/includes/header.php';
    ?>

    <main>
        <?php
            $request = $pdo->query("
                SELECT travaux.*, cours.titre AS cours_titre
                FROM travaux
                JOIN cours ON travaux.cours_id = cours.id
                WHERE travaux.ouvert = 1
            ");

            $travaux = $request->fetchAll();
        ?>

        <?php foreach ($travaux as $travail): ?>

            <div class="travail">
                <h2><?= htmlspecialchars($travail['titre']) ?></h2>
                <p><?= htmlspecialchars($travail['type']) ?></p>
                <p><?= htmlspecialchars($travail['remise']) ?></p>
                <a href="travail.php?travail=<?= urlencode($travail['id']) ?>">Voir le travail</a>
            </div>
        <?php endforeach; ?>

        
        
    </main>
</body>
</html>