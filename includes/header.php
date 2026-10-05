<header>
    <div class="logo">
        <img src="images/icon.png" alt="Logo">
        <h1><a href="index.php">Dex</a></h1>

        <?php if (isset($_SESSION['nom'])): ?>
            <p class="utilisateur">
                <?= htmlspecialchars($_SESSION['nom']) ?>
            </p>
        <?php endif; ?>
    </div>
</header>