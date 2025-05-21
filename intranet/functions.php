<?php
function parametres($title, $description, $keywords) {
?>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Marcepoil Mael">
    <meta name="description" content="<?php echo "$description" ?>">
    <meta name="keywords" content="<?php echo "$keywords" ?>">
    <title><?php echo "$title"; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/sae203/style.css">
    <link rel="icon" href="/sae203/logo/logo.png" type="image/png">
</head>
<?php
}


function entete() {  
?>
<header class="jumbotron pt-5 pb-5 text-center mb-0">
    <h1 class="boldonse-regular text-brand">Corsaire Nautique</h1>
    <img src="/sae203/logo/logo.png" class="mt-3 rounded" height="70" alt="Logo du site">
    <div class="mt-3">
        <?php // SI pas connecter
        if (!isset($_SESSION["utilisateur"])) {
        ?>
            <a class="text-primary" href="/tpr209/connexion.php">S'identifier</a> |
            <span id="user">Visiteur anonyme</span>
        <?php
        } else { // SINON
        ?>
            <a class="text-primary" href="/tpr209/deconnexion.php">Se déconnecter</a> |
            <span id="user"><?php echo $_SESSION["utilisateur"]; ?></span>
        <?php
        }
        ?>
    </div>
</header>
<?php
}


function navigation($actual) {
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand <?php echo ($actual == 'accueil') ? 'active' : '';?>" href="/tpr209/">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php echo ($actual == 'annonces') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/visualiser.php">Lister</a></li>
            <li class="nav-item <?php echo ($actual == 'proposer') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/proposer.php">Ajouter</a></li>
            <li class="nav-item <?php echo ($actual == 'modifier') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/modifier.php">Modifier</a></li>
            <li class="nav-item <?php echo ($actual == 'recherche') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/rechercher.php">Rechercher une annonce</a></li>
            <li class="nav-item <?php echo ($actual == 'profil') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/profil.php">Profil</a></li>
            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] == "admin") {
            ?>
                    <li class="nav-item <?php echo ($actual == 'admin') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/administration.php">Admin</a></li>
            <?php
                }
            }
            ?>
            <li class="nav-item <?php echo ($actual == 'wiki') ? 'active' : '';?>"><a class="nav-link" href="/tpr209/wiki.php"><b>Wiki</b></a></li>
        </ul>
        <form class="form-inline ml-auto">
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher">
            <button class="btn btn-primary" type="submit">Chercher</button>
        </form>
    </div>
</nav>
<?php
}

function pieddepage() {
    date_default_timezone_set('Europe/Paris');
    $date_heure = date('d/m/Y H:i:s');
    $annee = date('Y');
    $ip = $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
?>
    <footer class="container mt-4">
        <div class="jumbotron text-center bg-light py-4">
            <p>Samuel Laine - Yoann Provost - Omar Siddique - Alexis Loyer--Malhère - Elouan Foucher - Maël Marcepoil</p>
            <p>FI 1A Groupe 3</p>
            <p><?= $date_heure ?> | &copy; <?= $annee ?> | IP: <?= $ip ?> | Port: <?= $port ?></p>
            <p>
                <a class="text-secondary" href="https://instagram.com/" target="_blank"><i class="fab fa-instagram fa-2x mx-2"></i></a>
                <a class="text-secondary" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-2x mx-2"></i></a>
            </p>
        </div>
    </footer>
<?php
}
?>


<?php
function modifier_utilisateur($nom, $col, $newVal, &$utilisateurs, $usersFile, $isInSess, $recharger=false) {

    $index = array_search($nom, array_column($utilisateurs, 'utilisateur'));

    if ($index !== false) {
        /*echo "<pre>";
        print_r($utilisateurs[$index][$col]);
        echo " -> ";*/
        $utilisateurs[$index][$col] = $newVal;
        /*print_r($utilisateurs[$index][$col]);
        echo "</pre>";*/

        file_put_contents($usersFile, json_encode($utilisateurs, JSON_PRETTY_PRINT));
        $_SESSION['success-message'] = ucfirst($col) . " mis à jour avec succès.";
        if ($isInSess) {
            $_SESSION[$col] = $newVal;
        }
        if ($recharger) {
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
        

        
    } else {
        echo "<div class='alert alert-danger mt-3' id='error-alert-modif' role='alert'>
                Utilisateur non trouvé ou supprimé. Veuillez réessayer.
              </div>";
    }
}

function ajoute_id($fichier) {
    $annoncesFile = $fichier;
    $annoncesData = file_get_contents($annoncesFile);
    $annonces = json_decode($annoncesData, true);

    foreach ($annonces as &$annonce) {
        if (!isset($annonce["id"])) { // Si pas d'id, on en génère un
            $annonce["id"] = uniqid();
        }
    }

    file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));

    return "c'est ok";
}

//ajoute_id("../data/annonces.json");


function filtreAnnonce($annonce, $dateCritere, $placesCritere, $departCritere, $arriveeCritere) {

    if ($dateCritere && date("Y-m-d", strtotime($annonce['Date'])) !== $dateCritere) {
        return false;
    }

    if ($placesCritere && $annonce['Places'] < $placesCritere) {
        return false;
    }

    if ($departCritere && stripos($annonce['Depart'], $departCritere) === false) {
        return false;
    }

    if ($arriveeCritere && stripos($annonce['Arrivee'], $arriveeCritere) === false) {
        return false;
    }

    return true;
}
?>