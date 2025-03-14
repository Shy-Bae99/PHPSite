<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

include 'includes/db_connect.php';

// Vérifier que la connexion à la base de données est valide
if (!$conn) {
    die("Erreur de connexion à la base de données.");
}

// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM t_utilisateur_uti WHERE uti_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si l'utilisateur existe
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    // Déconnexion automatique si l'utilisateur n'est plus en base de données
    session_destroy();
    header("Location: connexion.php");
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <h2>Bienvenue, <?= htmlspecialchars($user['uti_pseudo']) ?> !</h2>
    <p>Email: <?= htmlspecialchars($user['uti_email']) ?></p>
    <p>Compte actif: <?= (int)$user['uti_compte_active'] === 1 ? 'Oui' : 'Non' ?></p>

    <p><a href="deconnexion.php">Se déconnecter</a></p>
</main>

<?php include 'includes/footer.php'; ?>
