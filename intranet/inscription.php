<?php
session_start();
include "functions.php";
$title = "Inscription";
$description = "Page d'inscription intranet";
$keywords = "inscription intranet";
parametres($title, $description, $keywords);
$actual = "inscrire";
navigation($actual);

if (!isUserAdmin()) {
    header('Location: index.php');
    exit;
}

$usersFile = 'datas_corsaire/salaries.json';
$errors = [];
$uploadDir = 'image_users/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur = isset($_POST['pseudo']) ? trim($_POST['pseudo']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
    $motdepasse = isset($_POST['password']) ? $_POST['password'] : '';
    $motdepasseConfirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';

    if (!$utilisateur || !$prenom || !$nom || !$email || !$motdepasse || !$motdepasseConfirm || !$role) {
        $errors[] = 'Tous les champs obligatoires doivent être remplis.';
    }

    if ($motdepasse !== $motdepasseConfirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    $usersContent = file_exists($usersFile) ? file_get_contents($usersFile) : '[]';
    $users = json_decode($usersContent, true);
    if (!is_array($users)) $users = [];

    foreach ($users as $user) {
        if (isset($user['email']) && $user['email'] === $email) {
            $errors[] = 'Cet email est déjà utilisé.';
            break;
        }
    }

    $photoName = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExt, $allowedExts)) {
            $errors[] = 'Le fichier doit être une image (jpg, jpeg, png, gif).';
        } else {
            $photoName = $utilisateur . '.png';
            $destPath = $uploadDir . $photoName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if ($fileExt !== 'png') {
                switch ($fileExt) {
                    case 'jpg':
                    case 'jpeg':
                        $image = imagecreatefromjpeg($fileTmpPath);
                        break;
                    case 'gif':
                        $image = imagecreatefromgif($fileTmpPath);
                        break;
                    default:
                        $image = null;
                        break;
                }

                if ($image) {
                    imagepng($image, $destPath);
                    imagedestroy($image);
                } else {
                    $errors[] = "Erreur lors de la conversion de l'image.";
                }
            } else {
                move_uploaded_file($fileTmpPath, $destPath);
            }
        }
    } else {
        $errors[] = 'La photo de profil est obligatoire.';
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
            'photo' => $photoName,
            'bio' => $bio
        ];

        $users[] = $newUser;
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

        header("Location: index.php?creation=success");
        exit;
    }
}
?>

<!-- Affichage des erreurs -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Formulaire -->
<form method="POST" action="" enctype="multipart/form-data">
    <div class="container">
  <div class="row">
    <div class="col-12 col-md-4 mx-auto"> <!-- 4 colonnes sur medium+, centré -->
      
      <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom:</label>
        <input type="text" id="prenom" name="prenom" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="nom" class="form-label">Nom:</label>
        <input type="text" id="nom" name="nom" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe:</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="role" class="form-label">Rôle:</label>
        <select id="role" name="role" class="form-select" required>
          <option value="">-- Sélectionner un rôle --</option>
          <option value="admin">Admin</option>
          <option value="modérateur">Modérateur</option>
          <option value="salarier">Salarier</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="bio" class="form-label">Bio (facultatif):</label>
        <textarea id="bio" name="bio" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label for="photo" class="form-label">Photo de profil (obligatoire):</label>
        <input type="file" id="photo" name="photo" accept="image/*" class="form-control" required>
      </div>

      <div class="d-grid text-center">
        <button type="submit" class="btn btn-info">Créer le compte</button>
      </div>

    </div>
  </div>
</div>

</form>

<?php
pieddepage();
?>
