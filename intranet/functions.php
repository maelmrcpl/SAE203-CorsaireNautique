<?php
function parametres($title, $description, $keywords) {
?>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Samuel Laine - Yoann Provost - Omar Siddique - Alexis Loyer--Malhère - Elouan Foucher - Maël Marcepoil">
    <meta name="description" content="<?php echo "$description" ?>">
    <meta name="keywords" content="<?php echo "$keywords" ?>">
    <title><?php echo "$title"; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/SAE203-CorsaireNautique/intranet/style.css">
    <link rel="icon" href="/SAE203-CorsaireNautique/intranet/logo/logo.png" type="image/png">
</head>
<?php
}


function entete() {  
?>
<header class="jumbotron pt-5 pb-5 text-center mb-0">
    <h1 class="boldonse-regular text-brand">Corsaire Nautique</h1>
    <img src="/SAE203-CorsaireNautique/intranet/logo/logo.png" class="mt-3 rounded" height="100" alt="Logo du site">
    <div class="mt-3">
        <?php // SI pas connecter
        if (!isset($_SESSION["utilisateur"])) {
        ?>
            <a class="text-primary" href="/SAE203-CorsaireNautique/intranet/connexion.php">S'identifier</a> |
            <span id="user">Visiteur anonyme</span>
        <?php
        } else { // SINON
        ?>
            <a class="text-primary" href="/SAE203-CorsaireNautique/intranet/deconnexion.php">Se déconnecter</a> |
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
    <a class="navbar-brand" href="/SAE203-CorsaireNautique/intranet/"><img src="/SAE203-CorsaireNautique/intranet/logo/logo.png" class="rounded" width="50" height="50"></a>
    <a class="navbar-brand <?php echo ($actual == 'accueil') ? 'active' : '';?>" href="/SAE203-CorsaireNautique/intranet/">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php echo ($actual == 'annuaire_entreprise') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/annuaire/salaries.php">Salariés</a></li>
            <li class="nav-item <?php echo ($actual == 'annuaire_partenaires') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/annuaire/partenaires.php">Partenaires</a></li>
            <li class="nav-item <?php echo ($actual == 'annuaire_clients') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/annuaire/clients.php">Clients</a></li>
            <?php
            if (isset($_SESSION["utilisateur"])) { 
                if ($_SESSION['role'] == 'admin') { 
            ?>
                    <li class="nav-item <?php echo ($actual == 'gestion_fichier') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/gestion_fichiers.php">Gestion des fichiers</a></li>
                    <li class="nav-item <?php echo ($actual == 'inscrire') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/inscription.php">Inscrire</a></li>

            <?php 
                }
            ?>
                <li class="nav-item <?php echo ($actual == 'profil') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/profil.php">Profil</a></li>
            <?php
            } 
            ?>
            <li class="nav-item <?php echo ($actual == 'wiki') ? 'active' : '';?>"><a class="nav-link" href="/SAE203-CorsaireNautique/intranet/wiki.php"><b>Wiki</b></a></li>
        </ul>
        
    </div>
</nav>
<?php
}

function pieddepage() {
    date_default_timezone_set('Europe/Paris');
    $date_heure = date('d/m/Y H:i:s');
    $annee = date('Y');
?>
    <footer class="container mt-4">
        <div class="jumbotron text-center bg-light py-4">
            <p>Samuel Laine - Yoann Provost - Omar Siddique - Alexis Loyer--Malhère - Elouan Foucher - Maël Marcepoil</p>
            <p>FI 1A Groupe 3</p>
            <p><?= $date_heure ?> | &copy; <?= $annee ?></p>
            <p>
                <a class="text-secondary" href="https://instagram.com/" target="_blank"><i class="fab fa-instagram fa-2x mx-2"></i></a>
                <a class="text-secondary" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-2x mx-2"></i></a>
            </p>
        </div>
    </footer>
<?php
}


function isUserConnected() {
    if (isset($_SESSION["utilisateur"])) {
        return true;
    } else {
        return false;
    }
}

function isUserAdmin() {
    if (isUserConnected()) {
        if ($_SESSION['role'] == "admin") {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
