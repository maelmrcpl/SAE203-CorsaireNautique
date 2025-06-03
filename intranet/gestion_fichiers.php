<?
	session_start();
	if(isset($_SESSION['utilisateur'])) {
		header("Location:connexion.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Affichage JSON avec édition admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    table {
      border-collapse: collapse;
      margin-top: 20px;
      width: 100%;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    select, button {
      padding: 10px;
      font-size: 16px;
    }
    .actions {
      white-space: nowrap;
    }
    input[type="text"] {
      width: 100%;
      box-sizing: border-box;
    }
  </style>
</head>
<body>

  <h1>Choisissez un fichier à afficher</h1>

  <label for="json-select">Fichier JSON :</label>
  <select id="json-select">
    <option value="">-- Sélectionnez un fichier --</option>
    <option value="datas_corsaire/clients.json">Clients</option>
    <option value="datas_corsaire/partenaires.json">Partenaires</option>
    <option value="datas_corsaire/salaries.json">Salariés</option>
  </select>

  <div id="table-container"></div>

  <script>
    let currentData = []; // pour stocker les données du fichier

    function loadJSON(file) {
      fetch(file)
        .then(response => {
          if (!response.ok) throw new Error('Erreur de chargement');
          return response.json();
        })
        .then(data => {
          currentData = data;
          createTable(data);
        })
        .catch(error => {
          console.error('Erreur :', error);
          document.getElementById('table-container').innerHTML =
            '<p style="color:red;">Impossible de charger le fichier.</p>';
        });
    }

    function createTable(data) {
      const container = document.getElementById('table-container');
      container.innerHTML = '';

      if (!Array.isArray(data) || data.length === 0) {
        container.innerHTML = '<p>Aucune donnée à afficher.</p>';
        return;
      }

      const table = document.createElement('table');
      const thead = document.createElement('thead');
      const tbody = document.createElement('tbody');

      const headers = Object.keys(data[0]);
      const headRow = document.createElement('tr');
      headers.forEach(header => {
        const th = document.createElement('th');
        th.textContent = header;
        headRow.appendChild(th);
      });
      if (utilisateur === "admin") {
        headRow.appendChild(document.createElement('th')).textContent = 'Actions';
      }
      thead.appendChild(headRow);

      data.forEach((item, rowIndex) => {
        const row = document.createElement('tr');
        headers.forEach(header => {
          const td = document.createElement('td');
          td.textContent = item[header];
          row.appendChild(td);
        });

        if (utilisateur === "admin") {
          const actionTd = document.createElement('td');
          actionTd.classList.add('actions');
          const editBtn = document.createElement('button');
          editBtn.textContent = 'Modifier';
          editBtn.onclick = () => enableEdit(row, headers, rowIndex);
          actionTd.appendChild(editBtn);
          row.appendChild(actionTd);
        }

        tbody.appendChild(row);
      });

      table.appendChild(thead);
      table.appendChild(tbody);
      container.appendChild(table);
    }

    function enableEdit(row, headers, index) {
      const cells = row.querySelectorAll('td');
      headers.forEach((header, i) => {
        const cell = cells[i];
        const input = document.createElement('input');
        input.type = 'text';
        input.value = cell.textContent;
        cell.innerHTML = '';
        cell.appendChild(input);
      });

      const actionsCell = cells[cells.length - 1];
      actionsCell.innerHTML = '';

      const saveBtn = document.createElement('button');
      saveBtn.textContent = 'Sauvegarder';
      saveBtn.onclick = () => saveEdit(row, headers, index);
      actionsCell.appendChild(saveBtn);
    }

    function saveEdit(row, headers, index) {
      const inputs = row.querySelectorAll('input');
      const newData = {};
      inputs.forEach((input, i) => {
        newData[headers[i]] = input.value;
      });

      // Met à jour currentData
      currentData[index] = newData;

      // Recharge le tableau avec les données mises à jour
      createTable(currentData);

      // 🔴 À ce stade, les modifications sont **dans le tableau seulement**
      // Pour sauvegarder dans le fichier JSON, il faut un script backend (PHP, Node, etc.)
    }
  </script>

</body>
</html>
