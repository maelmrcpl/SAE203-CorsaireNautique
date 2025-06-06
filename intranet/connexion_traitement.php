<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_POST['utilisateur']) || empty($_POST['motdepasse'])) {
    echo "<pre>";
    print_r($_POST);  // Pour debug
    echo "</pre>";
    die("Erreur : Données de connexion manquantes.");
}

$user = htmlspecialchars($_POST['utilisateur']);
$password = trim($_POST['motdepasse']);

//Chemin vers le fichier JSON mis à jour
$jsonFile = 'data_corsaire/salaries.json';

// Vérifier que le fichier existe
if (!file_exists($jsonFile)) {
    die("Erreur : le fichier salaries.json est introuvable.");
}

$jsonData = file_get_contents($jsonFile);
$utilisateurs = json_decode($jsonData, true);

// Vérifier si le JSON est bien décodé
if (!is_array($utilisateurs)) {
    die("Erreur : impossible de lire ou décoder le fichier JSON.");
}

$isUserFound = false;

foreach ($utilisateurs as $utilisateur) {
    if ($utilisateur["utilisateur"] === $user) {
        $isUserFound = true;

        if (password_verify($password, $utilisateur["motdepasse"])) {
            $_SESSION["utilisateur"] = $user;
            $_SESSION["email"] = $utilisateur["email"];
            $_SESSION["role"] = $utilisateur["role"];
            $_SESSION["prenom"] = $utilisateur["prenom"];
            $_SESSION["nom"] = $utilisateur["nom"];
            $_SESSION["bio"] = isset($utilisateur["bio"]) ? $utilisateur["bio"] : null;

            //Chemin vers la photo de profil (dans le dossier images_users)
            $photoFile = isset($utilisateur["photo"]) ? $utilisateur["photo"] : null;
            $_SESSION["photo"] = $photoFile ? "images_users/" . $photoFile : "images_users/default.png";

            header("Location: index.php");
            exit();
        } else {
            header("Location: connexion.php?erreur=2"); // mauvais mot de passe
            exit();
        }
    }
}

// Si aucun utilisateur trouvé
header("Location: connexion.php?erreur=1");
exit();
