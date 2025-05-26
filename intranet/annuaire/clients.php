<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des personnes</title>
</head>
<body>

<h1>Liste des personnes</h1>

<?php
$json = file_get_contents('../datas_corsaire/clients.json');
$personnes = json_decode($json, true);

if (is_array($personnes)) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    
    echo "<tr>";
    foreach (array_keys($personnes[0]) as $cle) {
        echo "<th>" . htmlspecialchars($cle) . "</th>";
    }
    echo "</tr>";
    
    foreach ($personnes as $personne) {
        echo "<tr>";
        foreach ($personne as $valeur) {
            echo "<td>" . htmlspecialchars($valeur) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Erreur lors de la lecture du fichier JSON.</p>";
}
?>

</body>
</html>
