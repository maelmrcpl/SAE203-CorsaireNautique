<?php
session_start();
include "../functions.php";
if (!isUserConnected()) {
        header('Location: ../connexion.php');
        exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<?php
parametres("Annuaire Clients - Corsaire Nautique", "Découvrez la liste complète de nos précieux clients chez Corsaire Nautique.", "clients, annuaire, Corsaire Nautique, fidélité");

?>

<body> <?php navigation("annuaire_clients"); // Barre de navigation ?>

<div class="container my-5">
    <h1 class="mb-5 text-center text-primary">Notre Base de Clients</h1>
    <p class="lead text-center mb-5 text-secondary">
        Explorez la liste de nos clients fidèles qui nous font confiance pour leurs aventures nautiques.
    </p>

    <div class="row justify-content-center">
        <?php
        $json = file_get_contents('../datas_corsaire/clients.json');
        $personnes = json_decode($json, true);

        // Pas de filtrage, on affiche directement toutes les personnes si le décodage JSON est réussi
        if (is_array($personnes) && !empty($personnes)) {
            foreach ($personnes as $personne) {
                echo "<div class='col-12 col-md-6 col-lg-4 mb-4'>";
                echo "<div class='card h-100 shadow-sm border-0 rounded overflow-hidden'>"; // Carte avec ombre, sans bordure, coins arrondis
                
                // En-tête de la carte - nom du client comme titre
                echo "<div class='card-header bg-primary text-white text-center py-3'>";
                echo "<h5 class='card-title mb-0'>" . htmlspecialchars($personne['nom'] ?? 'Client Inconnu') . "</h5>"; // Utilise 'nom' comme titre, avec fallback
                echo "</div>"; 

                // Corps de la carte - affichage dynamique des autres données
                echo "<div class='card-body text-center'>";
                
                // Affichage de la photo si disponible (assumant que 'photo' existe et contient un chemin)
                if (isset($personne['photo']) && !empty($personne['photo'])) {
                    echo "<div class='mb-3'>";
                    echo "<img src='" . htmlspecialchars($personne['photo']) . "' alt='" . htmlspecialchars($personne['nom'] ?? 'Client') . "' class='img-fluid rounded-circle border border-light' style='width: 120px; height: 120px; object-fit: cover; border-width: 3px !important;'>";
                    echo "</div>";
                }

                echo "<ul class='list-group list-group-flush text-left'>";
                foreach ($personne as $cle => $valeur) {
                    // Ignore 'nom' (déjà utilisé comme titre) et 'photo' (déjà affichée)
                    if ($cle === 'nom' || $cle === 'photo') {
                        continue;
		    }

                    echo "<li class='list-group-item d-flex justify-content-between align-items-center px-3 py-2'>";
                    echo "<span class='font-weight-bold text-dark'>" . htmlspecialchars(ucfirst($cle)) . ":</span>"; // Nom de la clé en gras
                    echo "<span>" . htmlspecialchars($valeur) . "</span>"; // Valeur
                    echo "</li>";
                }
                echo "</ul>";

                echo "</div>"; // Fin card-body
                
                // Pied de carte - peut être utilisé pour des actions
                echo "<div class='card-footer bg-light border-top text-center py-3'>";
                echo "</div>"; // Fin card-footer
                
                echo "</div>"; // Fin carte
                echo "</div>"; // Fin col
            }
        } else {
            // Message si aucun client n'est trouvé dans le fichier JSON
            echo "<div class='col-12'><div class='alert alert-info text-center' role='alert'>Aucun client à afficher pour le moment.</div></div>";
        }
        ?>
    </div>
</div>

<?php pieddepage(); // Pied de page ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
