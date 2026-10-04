<!DOCTYPE html>
<html lang="en">
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
            require __DIR__ . '/includes/db.php';

            $request = $pdo->query("
                SELECT travaux.*, cours.titre AS cours_titre
                FROM travaux
                JOIN cours ON travaux.cours_id = cours.id
                WHERE travaux.ouvert = 1
            ");
            $travaux = $request->fetchAll();
        ?>
    </main>

    <?php
        require __DIR__ . '/includes/footer.php';
    ?>
</body>
</html>