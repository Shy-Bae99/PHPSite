<?php
session_start();
$pageTitre = "Contact";
$metaDescription = "Page de contact de notre site.";
include 'includes/db_connect.php';

$errors = [];
$successMessage = "";
$nom = $prenom = $email = $message = "";

// 🔒 Protection CSRF : Génération du token s'il n'existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ⏳ Protection contre l'abus de requêtes
$limiteRequetes = 2; // Nombre maximum de requêtes
$intervalleTemps = 10; // En secondes

if (!isset($_SESSION['last_post_time'])) {
    $_SESSION['last_post_time'] = time();
    $_SESSION['post_count'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors["csrf"] = "Échec de la vérification CSRF.";
    }

    // Vérification de la fréquence des requêtes
    $tempsEcoule = time() - $_SESSION['last_post_time'];
    if ($tempsEcoule < $intervalleTemps) {
        $_SESSION['post_count']++;
        if ($_SESSION['post_count'] > $limiteRequetes) {
            $errors["spam"] = "Trop de requêtes en peu de temps. Veuillez patienter.";
        }
    } else {
        $_SESSION['last_post_time'] = time();
        $_SESSION['post_count'] = 1;
    }

    // Si pas d'erreurs de sécurité, traitement du formulaire
    if (empty($errors)) {
        // Récupération et nettoyage des entrées
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $email = trim($_POST["email"]);
        $message = trim($_POST["message"]);

        // Validation du nom
        if (empty($nom)) {
            $errors["nom"] = "Le nom est requis.";
        } elseif (strlen($nom) < 2 || strlen($nom) > 255) {
            $errors["nom"] = "Le nom doit contenir entre 2 et 255 caractères.";
        }

        // Validation du prénom (facultatif)
        if (!empty($prenom) && (strlen($prenom) < 2 || strlen($prenom) > 255)) {
            $errors["prenom"] = "Le prénom doit contenir entre 2 et 255 caractères.";
        }

        // Validation de l'email
        if (empty($email)) {
            $errors["email"] = "L'adresse e-mail est requise.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Format d'email invalide.";
        }

        // Validation du message
        if (empty($message)) {
            $errors["message"] = "Le message est requis.";
        } elseif (strlen($message) < 10 || strlen($message) > 3000) {
            $errors["message"] = "Le message doit contenir entre 10 et 3000 caractères.";
        }

        // Si pas d'erreurs, insertion dans la base de données
        if (empty($errors)) {
            $sql = "INSERT INTO contacts (nom, prenom, email, message) VALUES (?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $nom, $prenom, $email, $message);

                if ($stmt->execute()) {
                    $successMessage = "Le formulaire a bien été envoyé !";
                    // Réinitialisation des champs
                    $nom = $prenom = $email = $message = "";
                    // Regénérer un nouveau token CSRF après chaque soumission réussie
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                } else {
                    $errors["database"] = "Une erreur est survenue lors de l'envoi.";
                }

                $stmt->close();
            } else {
                $errors["database"] = "Impossible de préparer la requête SQL.";
            }
        }
    }
}

// Fermer la connexion
$conn->close();
?>

<?php include 'includes/header.php'; ?>

<main>
    <h2>Contact</h2>
    <form action="contact.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required minlength="2" maxlength="255">
        <span class="error"><?= $errors["nom"] ?? "" ?></span>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" minlength="2" maxlength="255">
        <span class="error"><?= $errors["prenom"] ?? "" ?></span>

        <label for="email">Email *</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        <span class="error"><?= $errors["email"] ?? "" ?></span>

        <label for="message">Message *</label>
        <textarea id="message" name="message" required minlength="10" maxlength="3000"><?= htmlspecialchars($message) ?></textarea>
        <span class="error"><?= $errors["message"] ?? "" ?></span>

        <div class="button-container">
            <button type="submit">Envoyer</button>
        </div>

        <?php if (!empty($successMessage)): ?>
            <p class="success"><?= $successMessage ?></p>
        <?php elseif (!empty($errors)): ?>
            <p class="error"><?= implode("<br>", $errors) ?></p>
        <?php endif; ?>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
