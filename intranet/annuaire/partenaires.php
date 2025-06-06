<?php
session_start();
include "../functions.php"; 
?>

<!DOCTYPE html>
<html lang="fr">
<?php
parametres("Annuaire Partenaires - Corsaire Nautique", "Découvrez nos précieux partenaires chez Corsaire Nautique, classés par secteurs d'activité.", "partenaires, annuaire, Corsaire Nautique, collaboration, entreprises");
if (!isUserConnected()) {
	header("Location: ../connexion.php";
	exit();
}
?>

<body> <?php navigation("annuaire_partenaires"); ?>

<div class="container mt-5 mb-5">
    <h1 class="mb-5 text-center text-primary">Nos Partenaires Privilégiés</h1>
    <p class="lead text-center mb-5 text-secondary">
        Découvrez les entreprises et organisations qui nous font confiance et avec lesquelles nous partageons des valeurs communes.
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        <?php
        $json = file_get_contents('../datas_corsaire/partenaires.json');
        $partenaires = json_decode($json, true);

        if (is_array($partenaires) && !empty($partenaires)) {
            foreach ($partenaires as $partenaire) {
                echo "<div class='col'>";
                echo "<div class='card h-100 shadow-sm border-0 rounded-3 overflow-hidden'>"; // Carte sans bordure, ombre légère, coins arrondis
                
                // En-tête de la carte avec la couleur primaire de Bootstrap
                echo "<div class='bg-primary text-white text-center p-4 rounded-top'>"; // Fond primaire, texte blanc, padding augmenté, coins arrondis en haut
                echo "</div>"; // Fermeture de l'en-tête de carte
                
                // Conteneur pour l'image, pour la positionner
                // mt-n5 ajusté à mt-n6 pour compenser la plus grande image
                echo "<div class='text-center mt-n6 position-relative z-1'>"; // Centré, marge négative pour remonter, position relative, z-index pour être au-dessus
                // Largeur et hauteur de l'image passées à 150px
                echo "<img src='" . htmlspecialchars($partenaire['photo']) . "' alt='" . htmlspecialchars($partenaire['nom']) . "' class='img-fluid rounded-circle border border-5 border-light' style='width: 150px; height: 150px; object-fit: cover;'>"; // Image responsive, circulaire, bordure autour de l'image (couleur de fond)
                echo "</div>"; // Fermeture du conteneur d'image

                echo "<div class='card-body pt-3 text-center'>"; // Padding haut ajusté
                echo "<h5 class='card-title text-dark mb-1'>" . htmlspecialchars($partenaire['nom']) . "</h5>"; // Titre foncé
                
                // Affichage du téléphone si disponible
                if (isset($partenaire['telephone']) && !empty($partenaire['telephone'])) {
                    echo "<p class='card-text'><small class='text-muted'><i class='fas fa-phone me-1'></i>" . htmlspecialchars($partenaire['telephone']) . "</small></p>";
                }
                
                // Affichage de l'adresse si disponible
                if (isset($partenaire['adresse']) && !empty($partenaire['adresse'])) {
                    echo "<p class='card-text'><small class='text-muted'><i class='fas fa-map-marker-alt me-1'></i>" . htmlspecialchars($partenaire['adresse']) . "</small></p>";
                }
                
                echo "</div>"; // Fermeture de card-body
                
                echo "<div class='card-footer bg-light border-top text-center pt-3 pb-3 rounded-bottom'>"; // Pied de carte clair, bordure haute, padding, coins arrondis en bas
                echo "</div>"; // Fermeture de card-footer
                echo "</div>"; // Fermeture de la carte
                echo "</div>"; // Fermeture de col
            }
        } else {
            echo "<div class='col-12'><div class='alert alert-info text-center' role='alert'>Aucun partenaire à afficher pour le moment.</div></div>";
        }
        ?>
    </div>
</div>

<?php pieddepage(); // Pied de page ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
