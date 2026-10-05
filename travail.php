<?php
    require __DIR__ . '/includes/db.php';
    $travailId = $_GET['travail'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $creneauxChoisis = $_POST['creneaux'] ?? [];
        $matricule = $_POST['matricule'] ?? '';
        $nom = $_POST['nom'] ?? '';

        $delete = $pdo->prepare("
            DELETE FROM disponibilites
            WHERE travail_id = ?
            AND matricule = ?
        ");

        $delete->execute([
            $travailId,
            $matricule
        ]);

        $insert = $pdo->prepare("
            INSERT INTO disponibilites (travail_id, creneau_id, matricule, nom) VALUES (?, ?, ?, ?)
        ");

        foreach ($creneauxChoisis as $creneauId) {
            $insert->execute([
                $travailId,
                $creneauId,
                $matricule,
                $nom
            ]);
        }

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
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/icon.png">
</head>
<body>
<div class="glass-container">

    <?php
        $titrePage = $travail['titre'];
        require __DIR__ . '/includes/header.php';
    ?>

    <main class="glass-container2 detail-travail">
                <div class="entete-travail">
                    <h1><?= htmlspecialchars($travail['titre']) ?></h1>
                    <p class="cours-travail"><?= htmlspecialchars($travail['cours_titre']) ?></p>
                    <p><?= htmlspecialchars($travail['description']) ?></p>
                </div>
                <div class="infos-travail">
                    <p>Type : <?= htmlspecialchars($travail['type']) ?></p>
                    <p>Disponible : <?= htmlspecialchars($travail['disponible']) ?></p>
                    <p>Remise : <?= htmlspecialchars($travail['remise']) ?></p>
                </div>
            
                <h2>Créneaux disponibles</h2>
                <form method="POST" class="form-disponibilites">

    <label>
        Matricule
        <input type="text" name="matricule" required>
    </label>

    <label>
        Nom
        <input type="text" name="nom" required>
    </label>

    <h3>Mes disponibilités</h3>

    <?php foreach ($creneaux as $creneau): ?>
        <label>
            <input
                type="checkbox"
                name="creneaux[]"
                value="<?= htmlspecialchars($creneau['id']) ?>">

            <?= htmlspecialchars($creneau['debut']) ?>
            à
            <?= htmlspecialchars($creneau['fin']) ?>
        </label>
    <?php endforeach; ?>

    <button type="submit">Enregistrer mes disponibilités</button>

</form>

            <div class="creneaux-liste">
                <?php foreach ($creneaux as $creneau): ?>
                <div class="creneau">
                    <p>Début : <?= htmlspecialchars($creneau['debut']) ?></p>
                    <p>Fin : <?= htmlspecialchars($creneau['fin']) ?></p>
                    <?php foreach ($disponibilites as $disponibilite): ?>
                        <?php if ($disponibilite['creneau_id'] === $creneau['id']): ?>
                            <p class="disponibilite">
                                <?= htmlspecialchars($disponibilite['matricule']) ?>
                                <?= htmlspecialchars($disponibilite['nom']) ?>
                            </p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </main>
        <?php require __DIR__ . '/includes/footer.php'; ?>
    </div>
</body>
</html>