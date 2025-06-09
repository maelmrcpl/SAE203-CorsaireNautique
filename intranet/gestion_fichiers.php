<?php
session_start();
include "functions.php";
if (!isUserConnected()) {
        header('Location: connexion.php');
        exit();
}
// $_SESSION['role'] = 'admin';
$role = $_SESSION['role'] ?? 'user'; // doit être 'admin' pour pouvoir modifier

$fichier = $_GET['file'] ?? null;
$jsonData = [];
$erreur = '';
$success = '';

// Sauvegarde des données modifiées (admin uniquement)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json_data']) && $role === 'admin') {
    $fichier = $_POST['file'];
    $jsonString = stripslashes($_POST['json_data']);

    $decoded = json_decode($jsonString, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        file_put_contents($fichier, json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $success = "Fichier mis à jour avec succès.";
    } else {
        $erreur = "Le contenu JSON est invalide.";
    }
}

// Lecture du fichier JSON
if ($fichier && file_exists($fichier)) {
    $contenu = file_get_contents($fichier);
    $jsonData = json_decode($contenu, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $erreur = "Erreur de lecture du fichier JSON.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<?php parametres("Gestions des fichiers", "Page de gestion des fichiers pour les admins", " "); ?>
<body>
<?php navigation("gestion_fichier"); ?>
    <div class="container">
        <h1 class="mt-4 mb-4">Éditeur de données JSON</h1>

        <div class="mb-3">
            <label for="json-select" class="form-label">Sélectionnez un fichier :</label>
            <select id="json-select" class="form-select">
                <option value="">-- Choisir un fichier --</option>
                <option value="?file=datas_corsaire/clients.json" <?= ($fichier === 'datas_corsaire/clients.json') ? 'selected' : '' ?>>Clients</option>
                <option value="?file=datas_corsaire/partenaires.json" <?= ($fichier === 'datas_corsaire/partenaires.json') ? 'selected' : '' ?>>Partenaires</option>
                <option value="?file=datas_corsaire/salaries.json" <?= ($fichier === 'datas_corsaire/salaries.json') ? 'selected' : '' ?>>Salariés</option>
            </select>
        </div>

        <?php if ($erreur): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($jsonData) && is_array($jsonData)): ?>
            <form method="post">
                <input type="hidden" name="file" value="<?= htmlspecialchars($fichier) ?>">
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <?php foreach (array_keys($jsonData[0]) as $col): ?>
                                    <th><?= htmlspecialchars(ucfirst($col)) ?></th>
                                <?php endforeach; ?>
                                <?php if ($role === 'admin'): ?>
                                    <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jsonData as $index => $ligne): ?>
                                <tr>
                                    <?php foreach ($ligne as $key => $val): ?>
                                        <td>
                                            <?php if ($role === 'admin'): ?>
                                                <input type="text" name="data[<?= $index ?>][<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars($val) ?>" class="form-control form-control-sm">
                                            <?php else: ?>
                                                <?= htmlspecialchars($val) ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <?php if ($role === 'admin'): ?>
                                        <td><!-- Placeholder pour supprimer une ligne plus tard --></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($role === 'admin'): ?>
                    <input type="hidden" name="json_data" id="json_data_field">
                    <button type="submit" class="btn btn-primary" onclick="prepareJson()">Sauvegarder</button>
                <?php endif; ?>
            </form>
        <?php elseif ($fichier): ?>
            <div class="alert alert-warning">Aucune donnée à afficher ou format JSON invalide.</div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('json-select').addEventListener('change', function () {
            if (this.value) window.location.href = this.value;
        });

        function prepareJson() {
            const inputs = document.querySelectorAll('input[name^="data"]');
            const data = {};

            inputs.forEach(input => {
                const match = input.name.match(/data\[(\d+)\]\[(.+?)\]/);
                if (match) {
                    const [_, i, key] = match;
                    if (!data[i]) data[i] = {};
                    data[i][key] = input.value;
                }
            });

            document.getElementById('json_data_field').value = JSON.stringify(Object.values(data));
        }
    </script>
<?php pieddepage(); ?>
</body>
</html>
