<?php
if (!isset($pageTitre)) {
    $pageTitre = "Mon Site";
}
if (!isset($metaDescription)) {
    $metaDescription = "Bienvenue sur mon site web.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
    <title><?= htmlspecialchars($pageTitre) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/includes/script.js"></script>
</head>
<body>

<header>
    <nav>
        <ul class="nav-list">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="utilisateur.php">Utilisateur</a></li>
        </ul>
    </nav>
</header>

</body>
</html>
