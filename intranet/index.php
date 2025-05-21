<?php
	session_start();
	include 'functions.php';

?>
<!DOCTYPE html>
<html lang="fr">

<?php parametres("Corsaire Nautique", "Corsaire Nautique - Page d'accueil", "homepage, index, accueil"); ?>

<body>
    
    <?php entete(); ?>

    

    <?php navigation("accueil"); ?>


    <section class="container mt-4 ml-5">

    	<h1>Bonjour et bienvenue sur <span class="boldonse-regular text-brand" style="font-size: 1.5rem;">Corsaire Nautique</span> ! </h1>
    	

    	
    </section>

    <?php pieddepage(); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
