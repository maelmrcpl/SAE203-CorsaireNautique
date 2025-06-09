<?php 
session_start();
include "functions.php";
?>
<!DOCTYPE html>
<html lang="fr">
<?php parametres("Wiki Corsaire Nautique", "", "") ?>

<body>
    <?php navigation("wiki"); ?>

    <section class="container mt-5 mb-5">
        <h3 class="mb-4 text-primary boldonse-regular">Wiki - Gestion des Utilisateurs en PHP</h3>

        <!-- Table des matières -->
        <div class="container mt-3">
            <div class="pt-4 pl-4 p-3 border rounded bg-light">
                <h6 class="boldonse-regular mb-3">Table des matières</h6>
                <ul>
                    <li><a href="#login">1. Mots de passe</a></li>
                    <li><a href="#inscription">2. Page d'inscription (inscription.php)</a></li>
                    <li><a href="#connexion">3. Page de connexion (connexion.php)</a></li>
                    <li><a href="#annuaires">4. Pages Annuaires (annuaire/*)</a></li>
                    <li><a href="#reservation">5. Système de Réservation (reservation.php, confirmation.php)</a></li>
                    <li><a href="#gestion-fichiers">6. Gestion des Fichiers (gestion_fichiers.php)</a></li>
                </ul>
            </div>
        </div>


        <div class="mt-5">
          <h5  class="boldonse-regular" id="login">1. Mots de passes utiles</h5>

          <table class="mt-3 table table-striped">
            <thead>
              <tr>
                <th>Nom user</th>
                <th>Mot de passe</th>
                <th>Role</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th><code>dgatel<code></th>
                <th><code>bonjour<code></th>
                <th>Admin</th>
              </tr>

              <tr>
                <th><code>jhuard<code></th>
                <th><code>bonjour<code></th>
                <th>Salarie</th>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 2. Page d'inscription -->
        <div class="mt-5">
            <h5 class="boldonse-regular" id="inscription">2. Page d'inscription (inscription.php)</h5>
            
            <h6 class="mt-4 boldonse-regular">Description :</h6>
            <p>Cette page permet aux administrateurs de créer un compte via un formulaire pour de nouveaux employés.</p>

            <h6 class="mt-4 boldonse-regular">Fichiers concernés :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Fichier</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>inscription.php</code></td>
                        <td>Page principale d'inscription</td>
                    </tr>
                    <tr>
                        <td><code>data/salaries.json</code></td>
                        <td>Base de données des employés</td>
                    </tr>
                    <tr>
                        <td><code>image_users/nom_user.png</code></td>
                        <td>Images de profil des utilisateurs</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Champs du formulaire :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Champ</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nom</td>
                        <td>Texte obligatoire</td>
                    </tr>
                    <tr>
                        <td>Prénom</td>
                        <td>Texte obligatoire</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>Email unique</td>
                    </tr>
                    <tr>
                        <td>Mot de passe</td>
                        <td>Mot de passe sécurisé</td>
                    </tr>
                    <tr>
                        <td>Confirmation du mot de passe</td>
                        <td>Vérification</td>
                    </tr>
                    <tr>
                        <td>Image de profil</td>
                        <td>Upload fichier</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Fonctionnalités :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Fonctionnalité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Validation des champs</td>
                    </tr>
                    <tr>
                        <td>Vérification de l'unicité de l'email</td>
                    </tr>
                    <tr>
                        <td>Hashage du mot de passe avec <code>password_hash()</code></td>
                    </tr>
                    <tr>
                        <td>Insertion dans la base de données</td>
                    </tr>
                    <tr>
                        <td>Ajout d'une photo de profil pour le compte</td>
                    </tr>
                    <tr>
                        <td>Seuls les administrateurs ont accès à cette page et peuvent créer un compte</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Sécurité :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Mesure de sécurité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>La page est accessible uniquement avec un compte administrateur</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 3. Page de connexion -->
        <div class="mt-5">
            <h5 class="boldonse-regular" id="connexion">3. Page de connexion (connexion.php)</h5>
            
            <h6 class="mt-4 boldonse-regular">Description :</h6>
            <p>Permet aux utilisateurs enregistrés dans la base de données de se connecter avec leur nom d'utilisateur et leur mot de passe.</p>

            <h6 class="mt-4 boldonse-regular">Fichiers concernés :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Fichier</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>connexion.php</code></td>
                        <td>Page de connexion</td>
                    </tr>
                    <tr>
                        <td><code>traitement_connexion.php</code></td>
                        <td>Traitement du formulaire de connexion</td>
                    </tr>
                    <tr>
                        <td><code>data/salaries.json</code></td>
                        <td>Base de données des employés</td>
                    </tr>
                    <tr>
                        <td><code>image_users/....png</code></td>
                        <td>Images de profil</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Champs du formulaire :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Champ</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Users</td>
                        <td>Nom d'utilisateur</td>
                    </tr>
                    <tr>
                        <td>Mot de passe</td>
                        <td>Mot de passe</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Fonctionnalités :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Fonctionnalité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Vérification des identifiants avec <code>password_verify()</code></td>
                    </tr>
                    <tr>
                        <td>Création de session PHP avec tous les différents paramètres de l'utilisateur</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Sécurité :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Mesure de sécurité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Utilisation des sessions sécurisées (<code>session_start()</code>)</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- 4. Pages Annuaires -->
        <div class="mt-5">
            <h5 class="boldonse-regular" id="annuaires">4. Pages Annuaires (annuaire/*)</h5>
            
            <h6 class="mt-4 boldonse-regular">Description générale :</h6>
            <p>Les pages annuaires permettent d'afficher les différents acteurs de Corsaire Nautique sous forme de cartes visuelles avec photos et informations détaillées.</p>

            <h6 class="mt-4 boldonse-regular" id="annuaire-clients">4.1. Annuaire Clients (annuaire/clients.php)</h6>
            
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Fichier source</strong></td>
                        <td><code>../datas_corsaire/clients.json</code></td>
                    </tr>
                    <tr>
                        <td><strong>Affichage</strong></td>
                        <td>Cartes Bootstrap avec photo circulaire, nom en en-tête et informations dynamiques</td>
                    </tr>
                    <tr>
                        <td><strong>Sécurité</strong></td>
                        <td>Accès restreint aux utilisateurs connectés, protection XSS avec <code>htmlspecialchars()</code></td>
                    </tr>
                    <tr>
                        <td><strong>Layout</strong></td>
                        <td>Grille responsive (col-12 col-md-6 col-lg-4) avec cartes de hauteur égale</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular" id="annuaire-partenaires">4.2. Annuaire Partenaires (annuaire/partenaires.php)</h6>
            
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Fichier source</strong></td>
                        <td><code>../datas_corsaire/partenaires.json</code></td>
                    </tr>
                    <tr>
                        <td><strong>Spécificité</strong></td>
                        <td>Design avec en-tête coloré et photo superposée (marge négative -75px)</td>
                    </tr>
                    <tr>
                        <td><strong>Champs affichés</strong></td>
                        <td>Nom, téléphone avec icône <code>fas fa-phone</code>, adresse avec icône <code>fas fa-map-marker-alt</code></td>
                    </tr>
                    <tr>
                        <td><strong>Image</strong></td>
                        <td>Photo circulaire 150x150px avec bordure blanche de 5px</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular" id="annuaire-salaries">4.3. Annuaire Salariés (annuaire/salaries.php)</h6>
            
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Fichier source</strong></td>
                        <td><code>../datas_corsaire/salaries.json</code></td>
                    </tr>
                    <tr>
                        <td><strong>Titre dynamique</strong></td>
                        <td>Utilise le champ <code>nom</code> ou <code>pseudo</code> comme fallback</td>
                    </tr>
                    <tr>
                        <td><strong>Filtrage</strong></td>
                        <td>Masque automatiquement le champ <code>motdepasse</code> pour la sécurité</td>
                    </tr>
                    <tr>
                        <td><strong>Formatage</strong></td>
                        <td>Conversion des clés avec underscores : <code>date_naissance</code> → "Date naissance"</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Fonctionnalités communes aux 3 annuaires :</h6>
            
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Fonctionnalité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Contrôle d'accès avec <code>isUserConnected()</code> et redirection vers connexion.php</td>
                    </tr>
                    <tr>
                        <td>Lecture de fichiers JSON avec <code>file_get_contents()</code> et <code>json_decode()</code></td>
                    </tr>
                    <tr>
                        <td>Affichage en cartes Bootstrap 4.6 avec design responsive</td>
                    </tr>
                    <tr>
                        <td>Gestion des erreurs : message d'alerte si aucune donnée disponible</td>
                    </tr>
                    <tr>
                        <td>Photos circulaires avec <code>object-fit: cover</code> pour maintenir les proportions</td>
                    </tr>
                    <tr>
                        <td>Navigation et pied de page inclus via les fonctions PHP <code>navigation()</code> et <code>pieddepage()</code></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <h5 class="boldonse-regular" id="reservation">5. Système de Réservation (reservation.php, confirmation.php)</h5>
            
            <h6 class="mt-4 boldonse-regular">Description générale :</h6>
            <p>Le système de réservation permet aux visiteurs du site vitrine de réserver directement des activités nautiques via l'intranet. Ce processus en deux étapes (formulaire + confirmation) offre une expérience utilisateur fluide et sécurisée.</p>

            <h6 class="mt-4 boldonse-regular" id="reservation-form">5.1. Page de Réservation (reservation.php)</h6>
            
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Interface</strong></td>
                        <td>Formulaire interactif avec sections pliables et validation en temps réel</td>
                    </tr>
                    <tr>
                        <td><strong>⚠ UX</strong></td>
                        <td>⚠ Choisir d'abord le nombre de personne/Pass/Catamaran + durée avant de sélectionner la date</td>
                    </tr>
                    <tr>
                        <td><strong>Gestion dynamique des horaires</strong></td>
                        <td>Système <code>shuttleSchedule</code> avec horaires par jour, filtrage des créneaux passés</td>
                    </tr>
                    <tr>
                        <td><strong>Validation en temps réel</strong></td>
                        <td>Contrôle des capacités (25 passagers bateau, 10 catamarans) avec messages d'alerte</td>
                    </tr>
                    <tr>
                        <td><strong>Calcul automatique des prix</strong></td>
                        <td>Fonction <code>calculerPrix()</code> mise à jour à chaque modification</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular" id="confirmation-page">5.2. Page de Confirmation (confirmation.php)</h6>
            
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Réception des données</strong></td>
                        <td>Traitement sécurisé des données POST du formulaire de réservation</td>
                    </tr>
                    <tr>
                        <td><strong>Enregistrement du client</strong></td>
                        <td>Ajoute le client si nouveau dans le fichier datas_corsaire/clients.json</td>
                    </tr>
                    <tr>
                        <td><strong>Enregistrement de la reservation</strong></td>
                        <td>Ajoute la (les) réservation(s) dans le fichier datas_corsaire/reservations.csv</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Flux utilisateur complet :</h6>
            <div class="container mt-3">
                <div class="pt-4 pl-4 p-3 border rounded bg-light">
                    <ol>
                        <li><strong>Arrivée depuis le site vitrine</strong> → Clic sur "Réserver une activité"</li>
                        <li><strong>Sélection des activités</strong> → Formulaire dynamique avec sections pliables</li>
                        <li><strong>Saisie informations personnelles</strong> → Champs obligatoires validés</li>
                        <li><strong>Choix date/heure</strong> → Horaires disponibles selon planning</li>
                        <li><strong>Calcul prix en temps réel</strong> → Affichage du montant total</li>
                        <li><strong>Soumission</strong> → Envoi POST vers confirmation.php</li>
                        <li><strong>Récapitulatif</strong> → Vérification des données saisies</li>
                        <li><strong>Validation finale</strong> → Confirmation de réservation</li>
                    </ol>
                </div>
            </div>

            <h6 class="mt-4 boldonse-regular">Sécurité :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Mesure</th>
                        <th>Implémentation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Validation côté client</strong></td>
                        <td>JavaScript avec <code>event.preventDefault()</code> si erreurs détectées</td>
                    </tr>
                    <tr>
                        <td><strong>Cohérence des données</strong></td>
                        <td>Synchronisation entre sélections et champs obligatoires</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="mt-5">
            <h5 class="boldonse-regular" id="gestion-fichiers">6. Gestion des Fichiers (gestion_fichiers.php)</h5>
            
            <h6 class="mt-4 boldonse-regular">Description :</h6>
            <p>Interface permettant aux administrateurs de modifier directement les données JSON des annuaires via un tableau éditable. Les utilisateurs standards ont accès en lecture seule.</p>

            <h6 class="mt-4 boldonse-regular">Fichiers concernés :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Fichier</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>gestion_fichiers.php</code></td>
                        <td>Interface de gestion des données JSON</td>
                    </tr>
                    <tr>
                        <td><code>datas_corsaire/*.json</code></td>
                        <td>Fichiers clients, partenaires et salariés</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Fonctionnalités :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Rôle</th>
                        <th>Accès</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Administrateur</strong></td>
                        <td>Modification et sauvegarde des données via inputs dans tableau</td>
                    </tr>
                    <tr>
                        <td><strong>Utilisateur</strong></td>
                        <td>Consultation en lecture seule des données</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 boldonse-regular">Sécurité :</h6>
            <table class="mt-3 table table-striped">
                <thead>
                    <tr>
                        <th>Mesure de sécurité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Contrôle du rôle <code>$_SESSION['role']</code> pour les modifications</td>
                    </tr>
                    <tr>
                        <td>Validation JSON avant sauvegarde</td>
                    </tr>
                    <tr>
                        <td>Protection XSS avec <code>htmlspecialchars()</code></td>
                    </tr>
                </tbody>
            </table>
        </div>

          


    </section>



    <?php pieddepage(); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
