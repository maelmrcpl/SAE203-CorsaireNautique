<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage des utilisateurs</title>
</head>
<body>

<h1>Liste des utilisateurs</h1>

<?php
$json = file_get_contents('../datas_corsaire/salaries.json');
$utilisateurs = json_decode($json, true);

if (is_array($utilisateurs)) {
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr>";
    foreach (array_keys($utilisateurs[0]) as $cle) {
        echo "<th>" . htmlspecialchars($cle) . "</th>";
    }
    echo "</tr>";

    foreach ($utilisateurs as $user) {
        echo "<tr>";
        foreach ($user as $cle => $valeur) {
            if ($cle === 'photo') {
                echo "<td><img src='" . htmlspecialchars($valeur) . "' alt='photo' width='100'></td>";
            } else {
                echo "<td>" . htmlspecialchars($valeur) . "</td>";
            }
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Erreur de lecture du fichier JSON.</p>";
}
?>

</body>
</html>
