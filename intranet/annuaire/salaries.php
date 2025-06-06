<?php
session_start();
include "../functions.php"; // Assurez-vous que ce chemin est correct
?>

<!DOCTYPE html>
<html lang="fr">
<?php
// Paramètres de la page
parametres("Annuaire Salariés - Corsaire Nautique", "Page présentant la liste des salaries et employés de Corsaire Nautique", "utilisateurs, employés, annuaire, Corsaire Nautique");
if (!isUserConnected()) {
	header("Location: ../connexion.php");
	exit();
}
?>
<body> <?php navigation('annuaire_entreprise'); // Assurez-vous que le nom de la navigation correspond à votre menu si 'annuaire_clients' est bien celui des salariés ?>

<div class="container my-5">
    <h1 class="mb-5 text-center text-primary">Notre Équipe et Utilisateurs</h1>
    <p class="lead text-center mb-5 text-secondary">
        Découvrez les personnes qui font vivre Corsaire Nautique et nos utilisateurs enregistrés.
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        <?php
        $json = file_get_contents('../datas_corsaire/salaries.json'); // Chemin vers le fichier des salariés/utilisateurs
        $utilisateurs = json_decode($json, true);

        if (is_array($utilisateurs) && !empty($utilisateurs)) {
            foreach ($utilisateurs as $user) {
                echo "<div class='col'>";
                echo "<div class='card h-100 shadow-sm border-0 rounded-3 overflow-hidden'>"; // Carte avec ombre, sans bordure, coins arrondis
                
                // En-tête de la carte avec la couleur primaire de Bootstrap
                echo "<div class='card-header bg-primary text-white text-center py-3'>";
                // Utilise le 'nom' ou un autre identifiant pertinent comme titre de la carte
                // Assurez-vous que 'nom' ou 'prenom' + 'nom' existe dans votre JSON
                echo "<h5 class='card-title mb-0'>" . htmlspecialchars($user['nom'] ?? $user['pseudo'] ?? 'Utilisateur Inconnu') . "</h5>";
                echo "</div>"; 

                // Corps de la carte
                echo "<div class='card-body text-center'>";
                
                // Affichage de la photo si disponible
                if (isset($user['photo']) && !empty($user['photo'])) {
                    echo "<div class='mb-3'>";
                    echo "<img src='" . htmlspecialchars($user['photo']) . "' alt='" . htmlspecialchars($user['nom'] ?? 'Utilisateur') . "' class='img-fluid rounded-circle border border-3 border-light' style='width: 120px; height: 120px; object-fit: cover;'>";
                    echo "</div>";
                }

                echo "<ul class='list-group list-group-flush text-start'>";
                foreach ($user as $cle => $valeur) {
                    // Ignore 'nom' (déjà utilisé comme titre) et 'photo' (déjà affichée)
                    // Ajoutez d'autres clés à ignorer si elles sont gérées différemment (ex: 'id' si non pertinent)
                    if ($cle === 'nom' || $cle === 'photo') {
                        continue;
                    }
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center px-3 py-2'>";
                    echo "<span class='fw-bold text-dark'>" . htmlspecialchars(ucfirst(str_replace('_', ' ', $cle))) . ":</span>"; // Nom de la clé en gras, formaté (ex: 'date_naissance' -> 'Date naissance')
                    echo "<span>" . htmlspecialchars($valeur) . "</span>"; // Valeur
                    echo "</li>";
                }
                echo "</ul>";

                echo "</div>"; // Fin card-body
                
                // Pied de carte (optionnel, pour des actions supplémentaires)
                echo "<div class='card-footer bg-light border-top text-center py-3 rounded-bottom'>";
                // Vous pourriez ajouter des boutons d'action ici, ex: "Voir profil"
                // echo "<a href='#' class='btn btn-outline-primary btn-sm'>Voir Profil</a>";
                echo "</div>"; // Fin card-footer
                
                echo "</div>"; // Fin carte
                echo "</div>"; // Fin col
            }
        } else {
            echo "<div class='col-12'><div class='alert alert-info text-center' role='alert'>Aucun utilisateur à afficher pour le moment.</div></div>";
        }
        ?>
    </div>
</div>

<?php pieddepage(); // Pied de page ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
