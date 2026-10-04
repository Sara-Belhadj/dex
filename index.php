<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
        require __DIR__ . '/includes/db.php';
        require __DIR__ . '/includes/header.php';
    ?>

    <main>
        <?php
            $request = $pdo->query("
                SELECT travaux.*, cours.titre AS cours_titre
                FROM travaux
                JOIN cours ON travaux.cours_id = cours.id
                WHERE travaux.ouvert = 1
                ORDER BY cours.titre
            ");

            $travaux = $request->fetchAll();
        ?>

        // Liste des options
        <form method="GET" action="index.php">
            <select name="cours" id="course-list">
                <option value="">Tous les cours</option>
                <option value="420-244-AH">Bases de données applicatives</option>
                <option value="420-245-AH">Programmation Web 1</option>
                <option value="420-248-AH">Programmation Web 2</option>
                <option value="420-253-AH">Projet de fin d’études</option>
            </select>

            <button type="submit">Filtrer</button>
        </form>

        <?php $coursActuel = null; ?>

        <?php foreach ($travaux as $travail): ?>

            <?php if ($coursActuel !== $travail['cours_titre']): ?>
                <h2><?= htmlspecialchars($travail['cours_titre']) ?></h2>
                <?php $coursActuel = $travail['cours_titre']; ?>
            <?php endif; ?>

            <div class="travail">
                <h2><?= htmlspecialchars($travail['titre']) ?></h2>
                <p><?= htmlspecialchars($travail['type']) ?></p>
                <p><?= htmlspecialchars($travail['remise']) ?></p>
                <a href="travail.php?travail=<?= urlencode($travail['id']) ?>">Voir le travail</a>
            </div>
        <?php endforeach; ?>


        
    </main>
    <?php 
        require __DIR__ . '/includes/footer.php';
    ?>
</body>
</html> 