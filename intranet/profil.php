<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?> !</h1>

    <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo de profil" width="150"><br><br>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
    <p><strong>Utilisateur :</strong> <?php echo htmlspecialchars($user['utilisateur']); ?></p>
    <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Rôle :</strong> <?php echo htmlspecialchars($user['role']); ?></p>
    <p><strong>Biographie :</strong> <?php echo htmlspecialchars($user['bio']); ?></p>

    <br><a href="deconnexion.php">Déconnexion</a>
</body>
</html>
