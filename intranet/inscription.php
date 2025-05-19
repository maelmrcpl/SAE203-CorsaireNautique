<?php
session_start();
//include "script/fonction.php";

$usersFile = 'data/salaries.json';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur = isset($_POST['pseudo']) ? trim($_POST['pseudo']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
    $motdepasse = isset($_POST['password']) ? $_POST['password'] : '';
    $motdepasseConfirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';

    // Vérification des champs requis
    if (!$utilisateur || !$prenom || !$nom || !$email || !$motdepasse || !$motdepasseConfirm || !$role) {
        $errors[] = 'Tous les champs obligatoires doivent être remplis.';
    }

    if ($motdepasse !== $motdepasseConfirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    $users = json_decode(file_get_contents($usersFile), true);
    foreach ($users as $user) {
        if (isset($user['email']) && $user['email'] === $email) {
            $errors[] = 'Cet email est déjà utilisé';
            break;
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($motdepasse, PASSWORD_DEFAULT);

        $newUser = [
            'utilisateur' => $utilisateur,
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'motdepasse' => $hashedPassword,
            'role' => $role,
            'photo' => 'Unknown.jpg',
            'bio' => $bio
        ];

        $users[] = $newUser;

        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
        
        echo '<div class="alert alert-success text-center">Inscription réussie !</div>';
        header("Location: index.php");
        exit;
    }
}
?>


<form method="POST" action="">
    <div class="mb-3">
        <label class="form-label">Pseudo:</label>
        <input type="text" name="pseudo" class="form-control" placeholder="Votre pseudo" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Prénom:</label>
        <input type="text" name="prenom" class="form-control" placeholder="Votre prénom" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nom:</label>
        <input type="text" name="nom" class="form-control" placeholder="Votre nom" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" placeholder="Ex: user@domaine.com" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe:</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirmer le mot de passe:</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        <small id="password_error" class="text-danger"></small>
    </div>

    <div class="mb-3">
        <label class="form-label">Rôle:</label>
        <select name="role" class="form-select" required>
            <option value="">-- Sélectionner un rôle --</option>
            <option value="admin">Admin</option>
            <option value="modérateur">Modérateur</option>
            <option value="salarier">Salarier</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Bio (facultatif):</label>
        <textarea name="bio" class="form-control" rows="3" placeholder="Parlez un peu de vous..."></textarea>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-info" onclick="return validerMotDePasse()">S'inscrire</button>
    </div>
</form>