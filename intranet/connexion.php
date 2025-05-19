<?php
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
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

<h1>Connexion</h1>

<?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

<form action="connexion_traitement.php" method="POST">
    <label for="utilisateur">Nom d'utilisateur :</label>
    <input type="text" name="utilisateur" required><br><br>

    <label for="motdepasse">Mot de passe :</label>
    <input type="password" name="motdepasse" required><br><br>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
