<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
print_r($_POST);

if (empty($_POST['utilisateur']) || empty($_POST['motdepasse'])) {
    echo "<pre>";
    print_r($_POST);  // Pour afficher ce que contient le tableau $_POST
    echo "</pre>";
    die("Erreur : Données de connexion manquantes.");
}

$user = htmlspecialchars($_POST['utilisateur']);
$password = trim($_POST['motdepasse']);

$jsonFile = 'datas_corsaire/salaries.json';

// Vérifier que le fichier existe
if (!file_exists($jsonFile)) {
    die("Erreur : le fichier utilisateurs.json est introuvable.");
}

$jsonData = file_get_contents($jsonFile);
$utilisateurs = json_decode($jsonData, true);

// Vérifier si le JSON est bien décodé
if ($user === null) {
    die("Erreur : impossible de lire le fichier JSON.");
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
            $_SESSION["photo"] = isset($utilisateur["photo"]) ? $utilisateur["photo"] : null;
            $_SESSION["bio"] = isset($utilisateur["bio"]) ? $utilisateur["bio"] : null;
            
            header("Location: index.php");
            exit();
        } else {
            header("Location: connexion.php?erreur=2");
            exit();
        }
    }
}

/*if (!$isUserFound) {
    header("Location: connexion.php?erreur=1");
    exit();
}*/
?>
