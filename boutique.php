<?php
$pageTitre = "Boutique";
$metaDescription = "Découvrez notre collection de bijoux et montres.";
include 'includes/header.php';

$products = [
    ['title' => 'Bague Élégante', 'category' => 'bague', 'image' => 'includes/images/Bagues/bague1.jpg', 'description' => 'Bague élégante en or rose, parfaite pour les occasions spéciales.'],
    ['title' => 'Bague Vintage', 'category' => 'bague', 'image' => 'includes/images/Bagues/bague2.jpg', 'description' => 'Bague vintage en or, avec un design unique.'],
    ['title' => 'Collier en Diamants', 'category' => 'collier', 'image' => 'includes/images/Colliers/collier1.jpg', 'description' => 'Collier en diamants, idéal pour les grandes occasions.'],
    ['title' => 'Collier Perlé', 'category' => 'collier', 'image' => 'includes/images/Colliers/collier2.jpg', 'description' => 'Collier perlé avec perles fines de culture.'],
    ['title' => 'Montre en Cuir', 'category' => 'montre', 'image' => 'includes/images/Montres/Montre3.jpg', 'description' => 'Montre en cuir avec cadran minimaliste et élégant.'],
    ['title' => 'Collier en Or', 'category' => 'collier', 'image' => 'includes/images/Colliers/collier3.jpg','description' => 'Collier en or 18 carats avec une pierre brillante.'],
    ['title' => 'Montre Sportive', 'category' => 'montre', 'image' => 'includes/images/Montres/Montre6.jpg', 'description' => 'Montre sportive avec fonctionnalités avancées et bracelet en mailles solides.'],
    ['title' => 'Bague de Mariage', 'category' => 'bague', 'image' => 'includes/images/Bagues/bague3.jpg', 'description' => 'Bague de mariage en platine, simple et élégante.'],
    ['title' => 'Collier Vintage', 'category' => 'collier', 'image' => 'includes/images/Colliers/collier4.jpg', 'description' => 'Collier vintage avec pendentif en argent.'],
    ['title' => 'Montre Luxe', 'category' => 'montre', 'image' => 'includes/images/Montres/Montre4.jpg', 'description' => 'Montre luxe avec mouvement automatique et bracelet en cuir de veau italien.'],
    ['title' => 'Bague Luxe', 'category' => 'bague', 'image' => 'includes/images/Bagues/bague4.jpg', 'description' => 'Bague de luxe sertie de diamants et en or blanc, rose, et jaune.'],
    ['title' => 'Collier Raffiné', 'category' => 'collier', 'image' => 'includes/images/Colliers/collier5.jpg', 'description' => 'Collier raffiné avec une pierre précieuse brillante.'],
    ['title' => 'Montre Classique', 'category' => 'montre', 'image' => 'includes/images/Montres/Montre2.jpg', 'description' => 'Montre classique avec bracelet en acier inoxydable.'],
    ['title' => 'Bague Moderne', 'category' => 'bague', 'image' => 'includes/images/Bagues/bague5.jpg', 'description' => 'Bague moderne en or plaqué 24Kt, idéale pour un usage quotidien.'],
   ['title' => 'Montre Design', 'category' => 'montre', 'image' => 'includes/images/Montres/Montre5.jpg', 'description' => 'Montre au design moderne avec un bracelet en métal.'],
    ['title' => 'Bague Designer', 'category' => 'bague', 'image' => 'includes/images/Bagues/bague6.jpg', 'description' => "Bague de desinger, parfaite pour vos soirées de fêtes" ],
    ['title' => 'Collier Sur Mesure', 'category' => 'collier', 'image' => 'includes/images/Colliers/collier6.jpg', 'description' => "Collier construit selon vos envies, n'hésitez pas à prendre contact avec nos maitres artisans en boutique, ou via la page de contact."],
    ['title' => 'Montre Connectée', 'category' => 'montre', 'image' => 'includes/images/Montres/Montre1.jpg', 'description' => 'Montre connectée parfaite pour garder un oeil attentif sur vos activités quotidiennes.'],
];

$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$filteredProducts = [];

if ($categoryFilter) {
    foreach ($products as $product) {
        if ($product['category'] == $categoryFilter) {
            $filteredProducts[] = $product;
        }
    }
} else {
    $filteredProducts = $products;
}
?>

<main class="shop-container">
    <aside class="filters">
        <h2>Filtres</h2>
        <form action="boutique.php" method="GET">
            <label for="category">Catégorie :</label>
            <select name="category" id="category">
                <option value="">Toutes</option>
                <option value="bague" <?php echo ($categoryFilter == 'bague') ? 'selected' : ''; ?>>Bagues</option>
                <option value="collier" <?php echo ($categoryFilter == 'collier') ? 'selected' : ''; ?>>Colliers</option>
                <option value="montre" <?php echo ($categoryFilter == 'montre') ? 'selected' : ''; ?>>Montres</option>
            </select>
            <button type="submit">Appliquer</button>
        </form>
    </aside>

    <section class="products">
        <?php foreach ($filteredProducts as $product) : ?>
            <div class="product-item">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
                <p class="product-description"><?php echo $product['description']; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
