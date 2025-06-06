<?php
include "script/functions.php";
$title = "Connexion";
$description = "Page de connexion de l'intranet";
$keywords = "connexion intranet";
parametres($title, $description, $keywords);
$actual = "Connexion";
navigation($actual);

// Affiche un message d'erreur si l'URL contient ?erreur=1 ou ?erreur=2
$message = '';
if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 1) {
        $message = "Nom d'utilisateur non trouvé.";
    } elseif ($_GET['erreur'] == 2) {
        $message = "Mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<body class="d-flex flex-column min-vh-100">

<!-- Contenu principal centré verticalement -->
<main class="container d-flex flex-column justify-content-center flex-grow-1 py-5">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 mx-auto"> <!-- Largeur de colonne ajustée pour un formulaire légèrement plus petit sur grands écrans -->
                <div class="card p-4 shadow-lg rounded-3 border-0"> <!-- Carte Bootstrap pour un joli conteneur, border-0 pour enlever la bordure par défaut -->
                    <h1 class="text-center mb-4 text-primary fw-bold">Connexion</h1> <!-- Ajout de text-primary pour la couleur du titre et fw-bold pour le rendre plus gras -->

                    <?php
                    // Logique PHP pour afficher les messages d'erreur (conservée telle quelle)
                    $message = '';
                    if (isset($_GET['erreur'])) {
                        if ($_GET['erreur'] == 1) {
                            $message = "Nom d'utilisateur non trouvé.";
                        } elseif ($_GET['erreur'] == 2) {
                            $message = "Mot de passe incorrect.";
                        }
                    }
                    if (!empty($message)) {
                        echo "<div class='alert alert-danger text-center mb-3 py-2' role='alert'>$message</div>"; // Utilisation de l'alerte Bootstrap pour l'erreur, py-2 pour un peu moins de hauteur
                    }
                    ?>

                    <form action="connexion_traitement.php" method="POST">
                        <div class="mb-3">
                            <label for="utilisateur" class="form-label">Nom d'utilisateur :</label>
                            <input type="text" id="utilisateur" name="utilisateur" class="form-control form-control-lg" required> <!-- form-control-lg pour des champs de saisie plus grands -->
                        </div>

                        <div class="mb-4"> <!-- Marge inférieure augmentée pour le champ du mot de passe -->
                            <label for="motdepasse" class="form-label">Mot de passe :</label>
                            <input type="password" id="motdepasse" name="motdepasse" class="form-control form-control-lg" required> <!-- form-control-lg pour des champs de saisie plus grands -->
                        </div>

                        <!-- Modification ici pour centrer le bouton -->
                        <div class="d-flex justify-content-center mb-3">
                            <button type="submit" class="btn btn-blue btn-lg rounded-pill">Se connecter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php
pieddepage();
?>

</body>
</html>
