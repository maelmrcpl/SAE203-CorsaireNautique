<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Wiki - Pages Utilisateur (PHP)</title>
</head>
<body>

  <h1>Wiki - Gestion des Utilisateurs en PHP</h1>

  <h2>1. Page d'inscription (inscription.php)</h2>

  <h3>Description :</h3>
  <p>Cette page permet aux administateur de créer un compte via un formulaire pour de nouveau employer.</p>

  <h3>Fichiers concernés :</h3>
  <ul>
    <li>inscription.php</li>
    <li>traitement_inscription.php</li>
    <li>db.php</li>
  </ul>

  <h3>Champs du formulaire :</h3>
  <ul>
    <li>Nom</li>
    <li>Prénom</li>
    <li>Email</li>
    <li>Mot de passe</li>
    <li>Confirmation du mot de passe</li>
    <li>Insertion image de profil</li>
  </ul>

  <h3>Fonctionnalités :</h3>
  <ul>
    <li>Validation des champs</li>
    <li>Vérification de l’unicité de l’email</li>
    <li>Hashage du mot de passe avec <code>password_hash()</code></li>
    <li>Insertion dans la base de données</li>
    <li>Ajout d'une photo de profil pour le compte.</li>
    <li>Seul les administrateurs on accès à cette page et peuve créer un compte</li>
  </ul>

  <h3>Sécurité :</h3>
  <ul>
    <li>La page est accessible qu'avec un compte administrateur</li>
  </ul>


  <h2>2. Page de connexion (connexion.php)</h2>

  <h3>Description :</h3>
  <p>Permet aux utilisateurs enregistrés dans la base de donnée de se connecter avec leur nom d'utilisateur et leur mot de passe.</p>

  <h3>Fichiers concernés :</h3>
  <ul>
    <li>connexion.php</li>
    <li>traitement_connexion.php</li>
    <li>data/salaries.json</li>
    <li>image_users/....png</li>
  </ul>

  <h3>Champs du formulaire :</h3>
  <ul>
    <li>Users</li>
    <li>Mot de passe</li>
  </ul>

  <h3>Fonctionnalités :</h3>
  <ul>
    <li>Vérification des identifiants avec <code>password_verify()</code></li>
    <li>Création de session PHP avec tout les différents paramètres de l'utilisateur.</li>
  </ul>

  <h3>Sécurité :</h3>
  <ul>
    <li>Utilisation des sessions sécurisées (<code>session_start()</code>, <code>session_regenerate_id()</code>)</li>
    <li>HTTPS recommandé</li>
    <li>Limitation des tentatives (optionnelle)</li>
  </ul>


  <h2>3. Page de profil (profil.php)</h2>

  <h3>Description :</h3>
  <p>Affiche les informations personnelles de l’utilisateur connecté et permet de les modifier et les paramètres de la variable session.</p>

  <h3>Fichiers concernés :</h3>
  <ul>
    <li>profil.php</li>
  </ul>

  <h3>Fonctionnalités :</h3>
  <ul>
    <li>Affichage des informations de l’utilisateur</li>
    <li>Vérification de la connexion utilisateur</li>
  </ul>

  <h3>Sécurité :</h3>
  <ul>
    <li>Accès uniquement pour les utilisateurs connectés</li>
  </ul>


</body>
</html>
