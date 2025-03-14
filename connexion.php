<?php
session_start(); // Démarrer la session en tout début de fichier

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $conn;
$pageTitre = "Connexion";
$metaDescription = "Page de connexion de notre site.";
include 'includes/header.php';
include 'includes/db_connect.php';

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pseudo = trim($_POST["pseudo"]);
    $motdepasse = $_POST["motdepasse"];

    // Validation des champs
    if (empty($pseudo)) {
        $errors["pseudo"] = "Le pseudo est requis.";
    }

    if (empty($motdepasse)) {
        $errors["motdepasse"] = "Le mot de passe est requis.";
    }

    // Vérification des identifiants
    if (empty($errors)) {
        $sql = "SELECT * FROM t_utilisateur_uti WHERE uti_pseudo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $pseudo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Vérification du mot de passe
            if (password_verify($motdepasse, $user['uti_motdepasse'])) {
                if ((int)$user['uti_compte_active'] === 1) { // Vérification stricte de l'activation
                    // Stocker l'utilisateur en session
                    $_SESSION['user_id'] = $user['uti_id'];
                    $_SESSION['user_pseudo'] = $user['uti_pseudo'];
                    $_SESSION['user_email'] = $user['uti_email'];

                    // Test pour voir si la session est bien enregistrée (à commenter après test)
                    // var_dump($_SESSION);
                    // die();

                    // Redirection vers la page utilisateur
                    header("Location: utilisateur.php");
                    exit;
                } else {
                    $errors["account"] = "Ton compte n'est pas activé. Vérifie ton email.";
                }
            } else {
                $errors["motdepasse"] = "Le mot de passe est incorrect.";
            }
        } else {
            $errors["pseudo"] = "Aucun utilisateur trouvé avec ce pseudo.";
        }
    }
}
?>

<main>
    <h2>Connexion</h2>
    <form action="connexion.php" method="POST">
        <label for="pseudo">Pseudo *</label>
        <input type="text" id="pseudo" name="pseudo" required minlength="2" maxlength="255">
        <span class="error"><?= $errors["pseudo"] ?? "" ?></span>

        <label for="motdepasse">Mot de passe *</label>
        <input type="password" id="motdepasse" name="motdepasse" required minlength="8" maxlength="72">
        <span class="error"><?= $errors["motdepasse"] ?? "" ?></span>

        <div class="button-container">
            <button type="submit">Se connecter</button>
        </div>

        <?php if (!empty($successMessage)): ?>
            <p class="success"><?= $successMessage ?></p>
        <?php elseif (!empty($errors)): ?>
            <p class="error"><?= $errors["account"] ?? $errors["database"] ?? "Erreur de connexion !" ?></p>
        <?php endif; ?>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
