<?php

// --- 1. Configuration & Data Retrieval ---
// Prices for Catamaran Rental (must match JavaScript for consistency)
$catamaranPrices = [
    "1h" => 30,
    "2h" => 50,
    "demi-journee" => 80,
    "journee" => 140
];

// Sanitize and retrieve common form data
$nom = htmlspecialchars($_POST['nom'] ?? '');
$prenom = htmlspecialchars($_POST['prenom'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');

// Retrieve boat reservation data
$bateau_date = htmlspecialchars($_POST['bateau_date'] ?? '');
$bateau_heure = htmlspecialchars($_POST['bateau_heure'] ?? '');
$as_enfant = (int)($_POST['as_enfant'] ?? 0);
$as_ado = (int)($_POST['as_ado'] ?? 0);
$as_adulte = (int)($_POST['as_adulte'] ?? 0);
$pj_enfant = (int)($_POST['pj_enfant'] ?? 0);
$pj_ado = (int)($_POST['pj_ado'] ?? 0);
$pj_adulte = (int)($_POST['pj_adulte'] ?? 0);
$pf_nb = (int)($_POST['pf_nb'] ?? 0);

// Retrieve bouée tractée data
$bouee_date = htmlspecialchars($_POST['bouee_date'] ?? '');
$bt_duree = (int)($_POST['bt_duree'] ?? 0);
$bt_personnes = (int)($_POST['bt_personnes'] ?? 0);

// Retrieve catamaran rental data
$catamaran_date = htmlspecialchars($_POST['catamaran_date'] ?? '');
$catamaran_duree = htmlspecialchars($_POST['catamaran_duree'] ?? '');
$catamaran_nb = (int)($_POST['catamaran_nb'] ?? 0);

// Initialize total price
$prix = 0;

// --- 2. Price Calculation ---

// Boat Prices
$prix += $as_ado * 6 + $as_adulte * 8;
$prix += $pj_ado * 10 + $pj_adulte * 24;
$prix += $pf_nb * 35; // Each family pass is 35€

// Bouée Tractée Price
// Validate and calculate price for Bouée Tractée
if ($bt_duree > 0 && $bt_personnes > 0 && $bt_personnes <= 10 && $bt_duree <= 120) {
    $prix += ($bt_duree / 15) * 24; // 24€ per 15 minutes
}

// Catamaran Price
if ($catamaran_nb > 0 && !empty($catamaran_duree) && isset($catamaranPrices[$catamaran_duree])) {
    $prix += $catamaran_nb * $catamaranPrices[$catamaran_duree];
}

// --- 3. Server-side Validation ---

$boat_booking_error = false;
$catamaran_booking_error = false;

// Server-side validation for boat capacity
$total_boat_passengers = $as_enfant + $as_ado + $as_adulte + $pj_enfant + $pj_ado + $pj_adulte;
// Assuming 1 family pass accounts for 4 people for capacity check.
$total_boat_passengers += $pf_nb * 4;

$max_boat_capacity = 25; // Maximum 25 people per time slot
$boat_reservations_file = 'reservations_bateau.json'; // Renamed to be more specific

// Only perform capacity check if a date and time for boat are selected AND if there are passengers
if (!empty($bateau_date) && !empty($bateau_heure) && $total_boat_passengers > 0) {
    $existing_reservations = file_exists($boat_reservations_file) ? json_decode(file_get_contents($boat_reservations_file), true) : [];

    $current_occupancy_for_slot = 0;
    foreach ($existing_reservations as $existing_res) {
        // Ensure to safely access nested arrays with null coalescing operator and check for 'bateau' key
        if (isset($existing_res['bateau']['date']) && isset($existing_res['bateau']['heure']) &&
            $existing_res['bateau']['date'] === $bateau_date &&
            $existing_res['bateau']['heure'] === $bateau_heure) {

            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_allersimples']['enfant'] ?? 0);
            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_allersimples']['ado'] ?? 0);
            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_allersimples']['adulte'] ?? 0);
            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_journee']['enfant'] ?? 0);
            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_journee']['ado'] ?? 0);
            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_journee']['adulte'] ?? 0);
            $current_occupancy_for_slot += (int)($existing_res['bateau']['pass_famille'] ?? 0) * 4;
        }
    }

    if (($current_occupancy_for_slot + $total_boat_passengers) > $max_boat_capacity) {
        $boat_booking_error = true;
        // Adjust price to remove boat-related costs if capacity is exceeded
        $prix -= ($as_ado * 6 + $as_adulte * 8);
        $prix -= ($pj_ado * 10 + $pj_adulte * 24);
        $prix -= ($pf_nb * 35);
    }
}

// Server-side validation for catamaran capacity
$max_catamarans_available = 10;
$catamaran_reservations_file = 'reservations_catamaran.json';

// Only perform capacity check if a date, duration, and number of catamarans are selected
if (!empty($catamaran_date) && !empty($catamaran_duree) && $catamaran_nb > 0) {
    $existing_catamaran_reservations = file_exists($catamaran_reservations_file) ? json_decode(file_get_contents($catamaran_reservations_file), true) : [];

    $current_catamaran_occupancy_for_slot = 0;
    foreach ($existing_catamaran_reservations as $existing_cat_res) {
        // Here you might need more sophisticated logic for overlapping durations
        // For simplicity, we check for same date and duration.
        // A full booking system would handle time slots / availability for each catamaran.
        if (isset($existing_cat_res['catamaran']['date']) && isset($existing_cat_res['catamaran']['duree']) &&
            $existing_cat_res['catamaran']['date'] === $catamaran_date &&
            $existing_cat_res['catamaran']['duree'] === $catamaran_duree) {
            $current_catamaran_occupancy_for_slot += (int)($existing_cat_res['catamaran']['nombre_catamarans'] ?? 0);
        }
    }

    if (($current_catamaran_occupancy_for_slot + $catamaran_nb) > $max_catamarans_available) {
        $catamaran_booking_error = true;
        // Adjust price to remove catamaran-related costs if capacity is exceeded
        if (isset($catamaranPrices[$catamaran_duree])) {
            $prix -= ($catamaran_nb * $catamaranPrices[$catamaran_duree]);
        }
    }
}


// --- 4. Prepare Reservation Data for Storage ---
$reservation_data = [
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'date_enregistrement' => date('Y-m-d H:i:s'),
    'prix_total' => $prix, // Store the calculated price
];

// Add boat reservation details if valid and selected
if (!empty($bateau_date) && !empty($bateau_heure) && $total_boat_passengers > 0 && !$boat_booking_error) {
    $reservation_data['bateau'] = [
        'date' => $bateau_date,
        'heure' => $bateau_heure,
        'pass_allersimples' => [
            'enfant' => $as_enfant,
            'ado' => $as_ado,
            'adulte' => $as_adulte
        ],
        'pass_journee' => [
            'enfant' => $pj_enfant,
            'ado' => $pj_ado,
            'adulte' => $pj_adulte
        ],
        'pass_famille' => $pf_nb
    ];
}

// Add bouée tractée details if selected and valid
if ($bt_duree > 0 && $bt_personnes > 0 && $bt_personnes <= 10 && $bt_duree <= 120) {
    $reservation_data['bouee_tractee'] = [
        'date' => $bouee_date,
        'duree_minutes' => $bt_duree,
        'personnes' => $bt_personnes
    ];
}

// Add catamaran rental details if valid and selected
if (!empty($catamaran_date) && !empty($catamaran_duree) && $catamaran_nb > 0 && !$catamaran_booking_error) {
    $reservation_data['catamaran'] = [
        'date' => $catamaran_date,
        'duree' => $catamaran_duree,
        'nombre_catamarans' => $catamaran_nb
    ];
}

// --- 5. Save Reservation to JSON Files ---

// Save to a general reservation file (optional, but good for all bookings in one place)
$all_reservations_file = 'all_reservations.json';
$all_existing_reservations = file_exists($all_reservations_file) ? json_decode(file_get_contents($all_reservations_file), true) : [];
$all_existing_reservations[] = $reservation_data;
file_put_contents($all_reservations_file, json_encode($all_existing_reservations, JSON_PRETTY_PRINT));


// Save boat reservation specifically if no error and it was part of the request
if (isset($reservation_data['bateau'])) {
    $donnees_existantes_boat_specific = file_exists($boat_reservations_file) ? json_decode(file_get_contents($boat_reservations_file), true) : [];
    $donnees_existantes_boat_specific[] = $reservation_data; // Storing full data is fine, or just boat part
    file_put_contents($boat_reservations_file, json_encode($donnees_existantes_boat_specific, JSON_PRETTY_PRINT));
}

// Save catamaran reservation specifically if no error and it was part of the request
if (isset($reservation_data['catamaran'])) {
    $donnees_existantes_catamaran_specific = file_exists($catamaran_reservations_file) ? json_decode(file_get_contents($catamaran_reservations_file), true) : [];
    $donnees_existantes_catamaran_specific[] = $reservation_data; // Storing full data is fine, or just catamaran part
    file_put_contents($catamaran_reservations_file, json_encode($donnees_existantes_catamaran_specific, JSON_PRETTY_PRINT));
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Confirmation de Réservation</title>
<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: auto; padding: 20px; background: #f9f9f9; color: #333; }
h1 { color: #2a5d84; text-align: center; margin-bottom: 30px; }
.section { background: #e8f0f8; padding: 20px; border-radius: 8px; margin-top: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.error { color: #cc0000; background-color: #ffe6e6; border: 1px solid #ffb3b3; font-weight: bold; padding: 15px; border-radius: 5px; margin-top: 20px; }
.success-message {
    text-align: center;
    font-size: 1.1em;
    color: #333;
    margin-top: 30px;
}
</style>
</head>
<body>

<h1>Merci pour votre réservation, <?= $prenom ?> <?= $nom ?> !</h1>

<?php if ($boat_booking_error || $catamaran_booking_error): ?>
    <div class="error">
        <?php if ($boat_booking_error): ?>
            <p>⚠️ **Erreur de réservation pour le bateau :** Le nombre de personnes dépasse la capacité maximale de <?= $max_boat_capacity ?> personnes pour le créneau horaire sélectionné (<?= $bateau_date ?> à <?= $bateau_heure ?>). Votre réservation de bateau n'a **pas** été enregistrée. Veuillez ajuster le nombre de passagers ou choisir un autre créneau.</p>
        <?php endif; ?>
        <?php if ($catamaran_booking_error): ?>
            <p>⚠️ **Erreur de réservation pour le catamaran :** Le nombre de catamarans demandé (<?= $catamaran_nb ?>) dépasse la limite disponible de <?= $max_catamarans_available ?> pour le créneau sélectionné (<?= $catamaran_date ?>). Votre réservation de catamaran n'a **pas** été enregistrée. Veuillez ajuster le nombre de catamarans ou choisir une autre date/durée.</p>
        <?php endif; ?>
        <p>Les autres réservations valides ont été prises en compte. Veuillez revenir à la page précédente pour corriger les erreurs.</p>
    </div>
<?php else: ?>
    <div class="section">
        <p><strong>Email :</strong> <?= $email ?></p>

        <?php if (isset($reservation_data['bateau'])): ?>
            <h3>Détails Réservation Bateau</h3>
            <p><strong>Date :</strong> <?= $reservation_data['bateau']['date'] ?> à <strong>Heure :</strong> <?= $reservation_data['bateau']['heure'] ?></p>
            <?php if ($reservation_data['bateau']['pass_allersimples']['enfant'] + $reservation_data['bateau']['pass_allersimples']['ado'] + $reservation_data['bateau']['pass_allersimples']['adulte'] > 0): ?>
                <p><strong>Pass Aller/Retour :</strong>
                    <?= $reservation_data['bateau']['pass_allersimples']['enfant'] ?> enfant(s), <?= $reservation_data['bateau']['pass_allersimples']['ado'] ?> ado(s), <?= $reservation_data['bateau']['pass_allersimples']['adulte'] ?> adulte(s)
                </p>
            <?php endif; ?>
            <?php if ($reservation_data['bateau']['pass_journee']['enfant'] + $reservation_data['bateau']['pass_journee']['ado'] + $reservation_data['bateau']['pass_journee']['adulte'] > 0): ?>
                <p><strong>Pass Journée :</strong>
                    <?= $reservation_data['bateau']['pass_journee']['enfant'] ?> enfant(s), <?= $reservation_data['bateau']['pass_journee']['ado'] ?> ado(s), <?= $reservation_data['bateau']['pass_journee']['adulte'] ?> adulte(s)
                </p>
            <?php endif; ?>
            <?php if ($reservation_data['bateau']['pass_famille'] > 0): ?>
                <p><strong>Pass Famille :</strong> <?= $reservation_data['bateau']['pass_famille'] ?> pass</p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($reservation_data['bouee_tractee'])): ?>
            <h3>Détails Bouée Tractée</h3>
            <p><strong>Date :</strong> <?= $reservation_data['bouee_tractee']['date'] ?></p>
            <p><strong>Durée :</strong> <?= $reservation_data['bouee_tractee']['duree_minutes'] ?> minutes pour <strong>Nombre de personnes :</strong> <?= $reservation_data['bouee_tractee']['personnes'] ?></p>
        <?php endif; ?>

        <?php if (isset($reservation_data['catamaran'])): ?>
            <h3>Détails Location Catamaran</h3>
            <p><strong>Date :</strong> <?= $reservation_data['catamaran']['date'] ?></p>
            <p><strong>Durée :</strong> <?= $reservation_data['catamaran']['duree'] ?></p>
            <p><strong>Nombre de catamarans :</strong> <?= $reservation_data['catamaran']['nombre_catamarans'] ?></p>
        <?php endif; ?>

        <p><strong>Prix total estimé :</strong> <?= $prix ?> €</p>
    </div>

    <p class="success-message">Votre réservation a bien été enregistrée.</p>
<?php endif; ?>

</body>
</html>