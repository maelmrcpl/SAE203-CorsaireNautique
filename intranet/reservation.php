<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Réservation Activités Nautique - Saint-Malo ⇌ Saint-Lunaire</title>
<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: auto; padding: 20px; background-color: #f8f8f8; color: #333; }
h1, h2, h3 { color: #2a5d84; }
h2, h3 { cursor: pointer; }
.section { margin-bottom: 25px; padding: 15px; background: #e8f0f8; border-radius: 10px; border: 1px solid #cce0f0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.details { display: none; margin-top: 15px; padding-left: 10px; border-left: 3px solid #a0cbe8; }
label { display: block; margin-bottom: 8px; font-weight: bold; }
input[type="text"], input[type="email"], input[type="number"], input[type="date"], select {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
input[type="number"] { width: 80px; display: inline-block; margin-right: 15px; }
label.required::after {
    content: " *";
    color: red;
}
.warning-message {
    color: #cc0000;
    background-color: #ffe6e6;
    border: 1px solid #ffb3b3;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
    display: none;
    font-weight: bold;
}
button {
    background-color: #2a5d84;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
button:hover {
    background-color: #1e4566;
}
</style>
<script>
function toggleDetails(id) {
    const section = document.getElementById(id);
    section.style.display = section.style.display === 'block' ? 'none' : 'block';
}

const shuttleSchedule = {
    "Lun": ["10h", "11h", "12h", "13h", "15h", "16h"],
    "Mar": ["10h", "12h", "13h", "15h"],
    "Mer": ["10h", "11h", "13h", "15h"],
    "Jeu": ["10h", "11h", "12h", "15h", "16h"],
    "Ven": ["10h", "11h", "12h", "15h", "16h"],
    "Sam": ["10h", "11h", "12h", "13h", "14h", "15h", "16h"],
    "Dim": ["10h", "11h", "12h", "13h", "14h", "15h", "16h"]
};

const catamaranPrices = {
    "1h": 30,
    "2h": 50,
    "demi-journee": 80,
    "journee": 140
};

function populateTimeSlots() {
    const selectedDateInput = document.getElementById("bateau_date");
    const timeSelect = document.getElementById("bateau_heure");
    const timeWarningDiv = document.getElementById("boat_time_warning");

    const currentSelectedTime = timeSelect.value;

    timeSelect.innerHTML = '<option value="">Sélectionnez une heure</option>';
    timeWarningDiv.style.display = 'none';

    const boatPassInputs = [
        document.getElementById("as_enfant"), document.getElementById("as_ado"), document.getElementById("as_adulte"),
        document.getElementById("pj_enfant"), document.getElementById("pj_ado"), document.getElementById("pj_adulte"),
        document.getElementById("pf_nb")
    ];

    let totalBoatPassengers = 0;
    boatPassInputs.forEach(input => {
        if (input) totalBoatPassengers += parseInt(input.value) || 0;
    });

    const isBoatBookingActive = totalBoatPassengers > 0;

    if (!selectedDateInput.value || !isBoatBookingActive) {
        timeSelect.removeAttribute('required');
        document.querySelector('label[for="bateau_heure"]').classList.remove('required');
        timeSelect.value = "";
        return;
    }

    const selectedDate = new Date(selectedDateInput.value);
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

    if (selectedDate < today) {
        selectedDateInput.value = '';
        timeSelect.removeAttribute('required');
        document.querySelector('label[for="bateau_heure"]').classList.remove('required');
        timeWarningDiv.textContent = "La date de réservation ne peut pas être antérieure à aujourd'hui. Veuillez choisir une autre date.";
        timeWarningDiv.style.display = 'block';
        timeSelect.value = "";
        return;
    }

    const dayOfWeek = selectedDate.toLocaleDateString('fr-FR', { weekday: 'short' });
    const dayMap = {
        "lun.": "Lun", "mar.": "Mar", "mer.": "Mer", "jeu.": "Jeu", "ven.": "Ven", "sam.": "Sam", "dim.": "Dim"
    };
    const scheduleKey = dayMap[dayOfWeek.toLowerCase()];

    const availableTimes = shuttleSchedule[scheduleKey];

    if (availableTimes && availableTimes.length > 0) {
        let optionsAdded = false;
        availableTimes.forEach(time => {
            const timeHour = parseInt(time.replace('h', ''));
            const currentTimeInMinutes = now.getHours() * 60 + now.getMinutes();
            const shuttleTimeInMinutes = timeHour * 60;

            if (selectedDate.toDateString() === today.toDateString()) {
                if (shuttleTimeInMinutes > currentTimeInMinutes) {
                    const option = document.createElement("option");
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                    optionsAdded = true;
                }
            } else {
                const option = document.createElement("option");
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
                optionsAdded = true;
            }
        });

        if (optionsAdded) {
            timeSelect.setAttribute('required', 'required');
            document.querySelector('label[for="bateau_heure"]').classList.add('required');
            if (currentSelectedTime && Array.from(timeSelect.options).some(option => option.value === currentSelectedTime)) {
                timeSelect.value = currentSelectedTime;
            } else {
                timeSelect.value = "";
            }
        } else {
            timeSelect.removeAttribute('required');
            document.querySelector('label[for="bateau_heure"]').classList.remove('required');
            timeWarningDiv.textContent = "Aucun horaire de navette disponible pour la date et l'heure sélectionnées (les horaires passés sont masqués). Veuillez choisir une autre date.";
            timeWarningDiv.style.display = 'block';
            timeSelect.value = "";
        }
    } else {
        timeSelect.removeAttribute('required');
        document.querySelector('label[for="bateau_heure"]').classList.remove('required');
        timeWarningDiv.textContent = "Aucun horaire de navette disponible pour la date sélectionnée. Veuillez choisir une autre date.";
        timeWarningDiv.style.display = 'block';
        timeSelect.value = "";
    }
}

function checkBoatPassengerTotal() {
    const as_enfant = parseInt(document.getElementById("as_enfant")?.value || 0);
    const as_ado = parseInt(document.getElementById("as_ado")?.value || 0);
    const as_adulte = parseInt(document.getElementById("as_adulte")?.value || 0);
    const pj_enfant = parseInt(document.getElementById("pj_enfant")?.value || 0);
    const pj_ado = parseInt(document.getElementById("pj_ado")?.value || 0);
    const pj_adulte = parseInt(document.getElementById("pj_adulte")?.value || 0);
    const pf_nb = parseInt(document.getElementById("pf_nb")?.value || 0);

    const totalBoatPassengers = as_enfant + as_ado + as_adulte + pj_enfant + pj_ado + pj_adulte + (pf_nb * 4);
    const maxCapacity = 25;
    const warningMessageDiv = document.getElementById("boat_capacity_warning");

    if (totalBoatPassengers > maxCapacity) {
        warningMessageDiv.textContent = `Attention : Le nombre total de passagers pour le bateau (${totalBoatPassengers}) dépasse la limite de ${maxCapacity} personnes par trajet. Veuillez ajuster votre sélection.`;
        warningMessageDiv.style.display = 'block';
        return false;
    } else {
        warningMessageDiv.style.display = 'none';
        return true;
    }
}

function checkCatamaranTotal() {
    const catamaranNb = parseInt(document.getElementById("catamaran_nb")?.value || 0);
    const maxCatamarans = 10;
    const warningMessageDiv = document.getElementById("catamaran_capacity_warning");

    if (catamaranNb > maxCatamarans) {
        warningMessageDiv.textContent = `Attention : Le nombre de catamarans (${catamaranNb}) dépasse la limite disponible de ${maxCatamarans}. Veuillez ajuster votre sélection.`;
        warningMessageDiv.style.display = 'block';
        return false;
    } else {
        warningMessageDiv.style.display = 'none';
        return true;
    }
}

function updateAllFields() {
    const bateauDateInput = document.getElementById("bateau_date");
    const bateauHeureSelect = document.getElementById("bateau_heure");
    const boueeDateInput = document.getElementById("bouee_date");
    const catamaranDateInput = document.getElementById("catamaran_date");

    const bateauDateLabel = document.querySelector('label[for="bateau_date"]');
    const bateauHeureLabel = document.querySelector('label[for="bateau_heure"]');
    const boueeDateLabel = document.querySelector('label[for="bouee_date"]');
    const catamaranDateLabel = document.querySelector('label[for="catamaran_date"]');

    const boatPassInputs = [
        document.getElementById("as_enfant"), document.getElementById("as_ado"), document.getElementById("as_adulte"),
        document.getElementById("pj_enfant"), document.getElementById("pj_ado"), document.getElementById("pj_adulte"),
        document.getElementById("pf_nb")
    ];

    let totalBoatPassengers = 0;
    boatPassInputs.forEach(input => {
        if (input) totalBoatPassengers += parseInt(input.value) || 0;
    });

    if (totalBoatPassengers > 0) {
        bateauDateInput.setAttribute('required', 'required');
        bateauDateLabel.classList.add('required');
        populateTimeSlots();
    } else {
        bateauDateInput.removeAttribute('required');
        bateauDateLabel.classList.remove('required');
        bateauHeureSelect.removeAttribute('required');
        bateauHeureLabel.classList.remove('required');
        bateauHeureSelect.value = "";
        bateauDateInput.value = "";
        document.getElementById("boat_time_warning").style.display = 'none';
    }

    const btPersonnesInput = document.getElementById("bt_personnes");
    const btDureeInput = document.getElementById("bt_duree");
    if (btPersonnesInput && btDureeInput && (parseInt(btPersonnesInput.value) > 0 || parseInt(btDureeInput.value) > 0)) {
        boueeDateInput.setAttribute('required', 'required');
        boueeDateLabel.classList.add('required');
    } else {
        boueeDateInput.removeAttribute('required');
        boueeDateLabel.classList.remove('required');
        boueeDateInput.value = "";
    }

    const catamaranDureeInput = document.getElementById("catamaran_duree");
    const catamaranNbInput = document.getElementById("catamaran_nb");
    // Ensure both duration and number are selected/entered to make date required
    if (catamaranDureeInput && catamaranNbInput && (catamaranDureeInput.value !== "" && parseInt(catamaranNbInput.value) > 0)) {
        catamaranDateInput.setAttribute('required', 'required');
        catamaranDateLabel.classList.add('required');
    } else {
        catamaranDateInput.removeAttribute('required');
        catamaranDateLabel.classList.remove('required');
        catamaranDateInput.value = "";
    }

    calculerPrix();
    checkBoatPassengerTotal();
    checkCatamaranTotal();
}

function calculerPrix() {
    const getVal = id => parseInt(document.getElementById(id)?.value || 0);
    const getSelectVal = id => document.getElementById(id)?.value || "";
    let total = 0;

    total += getVal("as_ado") * 6 + getVal("as_adulte") * 8;
    total += getVal("pj_ado") * 10 + getVal("pj_adulte") * 24;
    total += getVal("pf_nb") * 35;

    const duree = getVal("bt_duree");
    const personnes = getVal("bt_personnes");
    if (personnes > 0 && duree > 0 && personnes <= 10 && duree <= 120) {
        total += (duree / 15) * 24;
    }

    const catamaranDuree = getSelectVal("catamaran_duree");
    const catamaranNb = getVal("catamaran_nb");
    if (catamaranNb > 0 && catamaranDuree !== "" && catamaranPrices[catamaranDuree]) {
        total += catamaranNb * catamaranPrices[catamaranDuree];
    }

    document.getElementById("prix").textContent = total + " €";
}

document.addEventListener('DOMContentLoaded', () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const todayFormatted = `${yyyy}-${mm}-${dd}`;

    document.getElementById("bateau_date").setAttribute('min', todayFormatted);
    document.getElementById("bouee_date").setAttribute('min', todayFormatted);
    document.getElementById("catamaran_date").setAttribute('min', todayFormatted);

    const form = document.querySelector('form');

    const boatPassengerInputs = form.querySelectorAll(
        '#as_enfant, #as_ado, #as_adulte, #pj_enfant, #pj_ado, #pj_adulte, #pf_nb'
    );
    boatPassengerInputs.forEach(input => {
        input.addEventListener('input', updateAllFields);
    });

    document.getElementById("bateau_date").addEventListener('change', updateAllFields);

    const boueeInputs = form.querySelectorAll(
        '#bt_duree, #bt_personnes'
    );
    boueeInputs.forEach(input => {
        input.addEventListener('input', updateAllFields);
    });

    const catamaranInputs = form.querySelectorAll(
        '#catamaran_duree, #catamaran_nb, #catamaran_date'
    );
    catamaranInputs.forEach(input => {
        if (input.type === 'number' || input.tagName === 'SELECT') { // Listen for input on number and change on select
            input.addEventListener('input', updateAllFields); // For number input and select change
            input.addEventListener('change', updateAllFields); // Redundant for select but harmless, ensures date updates
        } else { // For date input
            input.addEventListener('change', updateAllFields);
        }
    });

    form.addEventListener('submit', (event) => {
        // Run all client-side validation checks
        let canSubmit = checkBoatPassengerTotal();
        canSubmit = checkCatamaranTotal() && canSubmit; // If boat is false, canSubmit remains false

        // If any validation fails, prevent the form from submitting
        if (!canSubmit) {
            event.preventDefault();
            // Optionally, you could add an alert here, but the warning messages should suffice
            // alert("Veuillez corriger les erreurs de réservation.");
        }
    });

    updateAllFields(); // Initial call to set up the form
});

</script>
</head>
<body>
<h1>Réservation d'activités Nautique - Saint-Malo ⇌ Saint-Lunaire</h1>
<form action="confirmation.php" method="POST">
    <div class="section">
        <h3>Informations personnelles</h3>
        <label class="required" for="nom">Nom : </label><input type="text" name="nom" id="nom" required>
        <label class="required" for="prenom">Prénom : </label><input type="text" name="prenom" id="prenom" required>
        <label class="required" for="email">Email : </label><input type="email" name="email" id="email" required>
        <label for="telephone">Numéro de téléphone : </label><input type="tel" name="telephone" id="telephone">
        <label for="adresse">Adresse : </label><input type="text" name="adresse" id="adresse">
    </div>

    <div class="section">
        <h2 onclick="toggleDetails('bateau_section')">⛴ Réservation Bateau ⬇</h2>
        <div id="bateau_section" class="details">
            <p>Sélectionnez le nombre de passagers (Pass Aller/Retour, Pass Journée ou Pass Famille) pour activer les champs de date et heure de réservation du bateau.</p>
            <label for="bateau_date">Date de réservation :
                <input type="date" name="bateau_date" id="bateau_date">
            </label>
            <label for="bateau_heure">Heure de départ :
                <select name="bateau_heure" id="bateau_heure">
                    <option value="">Sélectionnez une heure</option>
                </select>
            </label>
            <div id="boat_time_warning" class="warning-message"></div>
            <div id="boat_capacity_warning" class="warning-message"></div>

            <div class="section">
                <h3 onclick="toggleDetails('as_details')">Aller/Retour Simple ⬇</h3>
                <div id="as_details" class="details">
                    <p>Maximum 25 personnes par horaire pour l'ensemble des pass bateau.</p>
                    <label for="as_enfant">Enfants (-10 ans) : </label><input type="number" name="as_enfant" id="as_enfant" value="0" min="0" step="1">
                    <label for="as_ado">Adolescents (10–17 ans) : </label><input type="number" name="as_ado" id="as_ado" value="0" min="0" step="1">
                    <label for="as_adulte">Adultes (18+) : </label><input type="number" name="as_adulte" id="as_adulte" value="0" min="0" step="1">
                </div>
            </div>

            <div class="section">
                <h3 onclick="toggleDetails('pj_details')">Pass Journée ⬇</h3>
                <div id="pj_details" class="details">
                    <label for="pj_enfant">Enfants (-10 ans) : </label><input type="number" name="pj_enfant" id="pj_enfant" value="0" min="0" step="1">
                    <label for="pj_ado">Adolescents (10–17 ans) : </label><input type="number" name="pj_ado" id="pj_ado" value="0" min="0" step="1">
                    <label for="pj_adulte">Adultes (18+) : </label><input type="number" name="pj_adulte" id="pj_adulte" value="0" min="0" step="1">
                </div>
            </div>

            <div class="section">
                <h3 onclick="toggleDetails('pf_details')">Pass Famille ⬇</h3>
                <div id="pf_details" class="details">
                    <label for="pf_nb">Nombre de Pass Famille : </label><input type="number" name="pf_nb" id="pf_nb" value="0" min="0" step="1">
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2 onclick="toggleDetails('bouee_section')">🌊 Bouée Tractée ⬇</h2>
        <div id="bouee_section" class="details">
            <p>Sélectionnez la durée ou le nombre de personnes pour activer le champ de date de réservation de la bouée tractée.</p>
            <label for="bouee_date">Date de réservation :
                <input type="date" name="bouee_date" id="bouee_date">
            </label>
            <p><strong>Tarif :</strong> 24 € par tranche de 15 minutes (maximum 10 personnes, 120 minutes max)</p>
            <label for="bt_duree">Durée (en minutes) : </label><input type="number" name="bt_duree" id="bt_duree" value="0" min="0" max="120" step="15">
            <label for="bt_personnes">Nombre de personnes : </label><input type="number" name="bt_personnes" id="bt_personnes" value="0" min="0" max="10" step="1">
        </div>
    </div>

    <div class="section">
        <h2 onclick="toggleDetails('catamaran_section')">⛵ Location Catamaran ⬇</h2>
        <div id="catamaran_section" class="details">
            <p>Sélectionnez la durée ou le nombre de catamarans pour activer le champ de date de réservation. **Maximum 10 catamarans disponibles.**</p>
            <label for="catamaran_date">Date de location :
                <input type="date" name="catamaran_date" id="catamaran_date">
            </label>
            <label for="catamaran_duree">Durée :
                <select name="catamaran_duree" id="catamaran_duree">
                    <option value="">Sélectionnez une durée</option>
                    <option value="1h">1 heure (30 €)</option>
                    <option value="2h">2 heures (50 €)</option>
                    <option value="demi-journee">Demi-journée (80 €)</option>
                    <option value="journee">Journée complète (140 €)</option>
                </select>
            </label>
            <label for="catamaran_nb">Nombre de catamarans :
                <input type="number" name="catamaran_nb" id="catamaran_nb" value="0" min="0" max="10" step="1">
            </label>
            <div id="catamaran_capacity_warning" class="warning-message"></div>
        </div>
    </div>

    <p><strong>Prix estimé :</strong> <span id="prix">0 €</span></p>
    <button type="submit">Réserver</button>
</form>
</body>
</html>
