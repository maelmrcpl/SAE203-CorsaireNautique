<?php
session_start();
include "functions.php";
$title = "Profil";
$description = "Page de profil de l'uitlisateur sur l'intranet";
$keywords = "profil intranet";
parametres($title, $description, $keywords);
$actual = "Profil";
navigation($actual);

if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION;
?>

    <main class="container d-flex flex-column justify-content-center flex-grow-1 py-5">
        <div class="row justify-content-center"> <!-- Centered the row -->
            <div class="col-12 col-md-8 col-lg-6"> <!-- Adjusted column width for profile content -->
                <div class="card p-4 shadow-lg rounded-3 border-0"> <!-- Bootstrap card for a nice container -->
                    <h1 class="text-center mb-4 text-primary fw-bold">Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?> !</h1>

                    <div class="text-center mb-4">
                        <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo de profil" class="img-fluid rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;"> <!-- Responsive, rounded, and fixed size image -->
                    </div>

                    <div class="mb-3">
                        <p class="lead mb-2"><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
                        <p class="lead mb-2"><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
                        <p class="lead mb-2"><strong>Utilisateur :</strong> <?php echo htmlspecialchars($user['utilisateur']); ?></p>
                        <p class="lead mb-2"><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="lead mb-2"><strong>Rôle :</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                        <p class="lead mb-0"><strong>Biographie :</strong></p>
                        <p class="text-muted"><?php echo htmlspecialchars($user['bio']); ?></p> <!-- Text-muted for biography -->
                    </div>

                    <!-- Modification ici pour centrer le bouton -->
                    <div class="d-flex justify-content-center mt-4">
                        <a href="deconnexion.php" class="btn btn-danger btn-lg rounded-pill">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
pieddepage();
?>
