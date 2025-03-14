<?php
global $conn;
$pageTitre = "Inscription";
$metaDescription = "Page d'inscription de notre site.";
include 'includes/header.php';
include 'includes/db_connect.php';

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pseudo = trim($_POST["pseudo"]);
    $email = trim($_POST["email"]);
    $motdepasse = $_POST["motdepasse"];
    $motdepasse_confirmation = $_POST["motdepasse_confirmation"];

    // Validation des champs
    if (empty($pseudo) || strlen($pseudo) < 2 || strlen($pseudo) > 255) {
        $errors["pseudo"] = "Le pseudo est requis et doit faire entre 2 et 255 caractères.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Un email valide est requis.";
    }

    if (empty($motdepasse) || strlen($motdepasse) < 8) {
        $errors["motdepasse"] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if ($motdepasse !== $motdepasse_confirmation) {
        $errors["motdepasse_confirmation"] = "Les mots de passe ne correspondent pas.";
    }

    // Si pas d'erreurs, on insère dans la base de données
    if (empty($errors)) {
        // Vérifie si le pseudo ou l'email existe déjà
        $sql = "SELECT * FROM t_utilisateur_uti WHERE uti_pseudo = ? OR uti_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $pseudo, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors["database"] = "Le pseudo ou l'email est déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashed_password = password_hash($motdepasse, PASSWORD_DEFAULT);

            // Insertion dans la base de données, compte activé immédiatement
            $sql = "INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse, uti_compte_active) VALUES (?, ?, ?, 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $pseudo, $email, $hashed_password);
            if ($stmt->execute()) {
                $successMessage = "Inscription réussie ! Tu peux maintenant te connecter.";
            } else {
                $errors["database"] = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
}
?>

<main>
    <h2>Inscription</h2>
    <form action="inscription.php" method="POST">
        <label for="pseudo">Pseudo *</label>
        <input type="text" id="pseudo" name="pseudo" required minlength="2" maxlength="255">
        <span class="error"><?= $errors["pseudo"] ?? "" ?></span>

        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required>
        <span class="error"><?= $errors["email"] ?? "" ?></span>

        <label for="motdepasse">Mot de passe *</label>
        <input type="password" id="motdepasse" name="motdepasse" required minlength="8" maxlength="72">
        <span class="error"><?= $errors["motdepasse"] ?? "" ?></span>

        <label for="motdepasse_confirmation">Confirmation du mot de passe *</label>
        <input type="password" id="motdepasse_confirmation" name="motdepasse_confirmation" required minlength="8" maxlength="72">
        <span class="error"><?= $errors["motdepasse_confirmation"] ?? "" ?></span>

        <div class="button-container">
            <button type="submit">S'inscrire</button>
        </div>

        <?php if (!empty($successMessage)): ?>
            <p class="success"><?= $successMessage ?></p>
        <?php elseif (!empty($errors)): ?>
            <p class="error"><?= $errors["database"] ?? "Erreur d'inscription !" ?></p>
        <?php endif; ?>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
