<?php
    require __DIR__ . '/includes/db.php';
    $travailId = $_GET['travail'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $creneauId = $_POST['creneau_id'];
        $matricule = $_POST['matricule'];
        $nom = $_POST['nom'];

        $insert = $pdo->prepare("
            INSERT INTO disponibilites (travail_id, creneau_id, matricule, nom) VALUES (?, ?, ?, ?)
        ");

        $insert->execute([
            $travailId,
            $creneauId,
            $matricule,
            $nom
        ]);

        header('Location: travail.php?travail=' . urlencode($travailId), true, 303);
        exit;
    }

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

    $requestCreneaux = $pdo->prepare("
        SELECT *
        FROM creneaux
        WHERE travail_id = ?
        ORDER BY debut
    ");
    $requestCreneaux->execute([$travailId]);
    $creneaux = $requestCreneaux->fetchAll();

    $requestDisponibilites = $pdo->prepare("
        SELECT *
        FROM disponibilites
        WHERE travail_id = ?
    ");

    $requestDisponibilites->execute([$travailId]);
    $disponibilites = $requestDisponibilites->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
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
        </div>
            <main class="glass-container2">
                <h1><?= htmlspecialchars($travail['titre']) ?></h1>
                <p><?= htmlspecialchars($travail['cours_titre']) ?></p>
                <p><?= htmlspecialchars($travail['description']) ?></p>
                <p>Type : <?= htmlspecialchars($travail['type']) ?></p>
                <p>Disponible : <?= htmlspecialchars($travail['disponible']) ?></p>
                <p>Remise : <?= htmlspecialchars($travail['remise']) ?></p>
            
                <h2>Créneaux disponibles</h2>

                <?php foreach ($creneaux as $creneau): ?>

                    <div class="creneau">

                        <p>Début : <?= htmlspecialchars($creneau['debut']) ?></p>
                        <p>Fin : <?= htmlspecialchars($creneau['fin']) ?></p>

                        <?php foreach ($disponibilites as $disponibilite): ?>
                            <?php if ($disponibilite['creneau_id'] === $creneau['id']): ?>
                                <p>
                                    <?= htmlspecialchars($disponibilite['matricule']) ?>
                                    <?= htmlspecialchars($disponibilite['nom']) ?>
                                </p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <form method="POST">
                            <input
                                type="hidden"
                                name="creneau_id"
                                value="<?= htmlspecialchars($creneau['id']) ?>">
                            <label>
                                Matricule
                                <input type="text" name="matricule" required>
                            </label>
                            <label>
                                Nom
                                <input type="text" name="nom" required>
                            </label>
                            <button type="submit">Je suis disponible</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </main>
    </div>
</body>
</html>