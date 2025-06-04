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

    	<h1>Bonjour et bienvenue sur l'intranet de <span class="boldonse-regular text-brand" style="font-size: 1.5rem;">Corsaire Nautique</span> ! </h1>
    	
        <div class="row mb-3 mt-4">
            <div class="col-12">
                <h2 class="h4 text-secondary mb-3">
                    <i class="fas fa-compass text-primary me-2"></i>
                    Vos services à portée de clic
                </h2>
                <p class="text-muted">Accédez rapidement aux outils et services essentiels de votre quotidien professionnel.</p>
            </div>
        </div>

        <div class="row">

            <!-- Card Site Vitrine -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-blue text-white mb-3 rounded">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h5 class="card-title font-weight-bold text-dark">Site Vitrine</h5>
                        <p class="card-text text-muted">Découvrez notre site web public, nos services et notre actualité.</p>
                        <button class="btn btn-blue btn-custom btn-sm px-4" onclick="visitSite();" style="color: white;">
                            <i class="fas fa-external-link-alt mr-2"></i>Visiter le site
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Card Contacter RH -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-danger text-white mb-3 rounded">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="card-title font-weight-bold text-dark">Contacter les RH</h5>
                        <p class="card-text text-muted">Besoin d'aide pour vos questions administratives, congés ou autre sujet RH ?</p>
                        <button class="btn btn-danger btn-custom btn-sm px-4" onclick="contactRH();">
                            <i class="fas fa-envelope mr-2"></i>Contacter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card Ticket Support -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-info text-white mb-3 rounded">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h5 class="card-title font-weight-bold text-dark">Ticket Support IT</h5>
                        <p class="card-text text-muted">Un problème informatique ? Créez un ticket et notre équipe vous aidera.</p>
                        <button class="btn btn-info btn-custom btn-sm px-4" onclick="createTicket();">
                            <i class="fas fa-plus mr-2"></i>Créer un ticket
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card Boîte à Idées -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-warning text-white mb-3 rounded">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h5 class="card-title font-weight-bold text-dark">Boîte à Idées</h5>
                        <p class="card-text text-muted">Une idée pour améliorer notre entreprise ? Partagez vos suggestions avec nous.</p>
                        <button class="btn btn-warning btn-custom btn-sm px-4" onclick="shareIdea();" style="color: white;">
                            <i class="fas fa-share mr-2"></i>Partager une idée
                        </button>
                    </div>
                </div>
            </div>

            

        </div>

    	
    </section>

    <?php pieddepage(); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function visitSite() {
            $(event.target).addClass('btn-outline-danger').removeClass('btn-danger');
            setTimeout(() => {
                window.location.href = 'http://172.18.203.208/wordpress/';
            }, 200);
        }
        function contactRH() {
            $(event.target).addClass('btn-outline-danger').removeClass('btn-danger');
            setTimeout(() => {
                window.location.href = 'mailto:ressources.humaines@contact.corsaire-nautique.com?subject=Demande d\'information - Intranet&body=Bonjour,%0D%0A%0D%0AJe vous contacte via l\'intranet pour...%0D%0A%0D%0ACordialement';
            }, 200);
        }
        function createTicket() {
            setTimeout(() => {
                window.location.href = '#';
            }, 200);
        }
        function shareIdea() {
            setTimeout(() => {
                window.location.href = '#';
            }, 200);
        }
    </script>
</body>
</html>
