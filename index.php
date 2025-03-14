<?php
$pageTitre = "Accueil";
$metaDescription = "Bienvenue sur la page d'accueil de notre site.";
include 'includes/header.php';
?>
<h1>Bienvenue sur notre boutique en ligne,le site est en construction, veuillez excuser son apparence! </h1>
<div id="carouselExampleFade" class="carousel slide carousel-fade custom-carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="includes/images/Bijoux1.jpg" class="d-block w-100" alt="Bijoux 1">
        </div>
        <div class="carousel-item">
            <img src="includes/images/Bijoux2.jpg" class="d-block w-100" alt="Bijoux 2">
        </div>
        <div class="carousel-item">
            <img src="includes/images/Bijoux3.jpg" class="d-block w-100" alt="Bijoux 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>

<?php include 'includes/footer.php'; ?>
