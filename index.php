<?php
require_once 'src/Models/joueurs.php';


// Usage example:

$db = new Database();
$conn = $db->getConnection();

$joueurs = new Joueurs($conn);

// Insert example
$insertData = array('name' => 'khadija', 'img' => 'Khadija.jpg', 'position' => 'CB1', 'rating' => 89);
if ($joueurs->insertRecord('joueurs',$insertData)) {
    echo "inserer des donnes avec succees";
} else {
    echo "Echec d'insertion des donnees !";
}

// Update example
$updateData = array('name' => 'Eissa', 'img' => 'CdnEissa.jpg', 'position' => 'MR', 'rating' => 58);
if ($joueurs->updateRecord('joueurs',$updateData,6)) {
    echo "modification avec succees";
} else {
    echo "Echec de modification !";
}


// Delete example
if ($joueurs->deleteRecord('joueurs',83)) {
    echo " supprime avec succees.";
} else {
    echo "Echec de la suppression ";
}


// Select example


$selectResult = $joueurs->selectRecords('joueurs');
if ($selectResult) {
  echo "<table border='1'>";
  echo "<tr>";
  foreach ($selectResult[0] as $key => $value) {
    echo "<th>$key</th>";
}
echo "</tr>";
foreach ($selectResult as $row) {
  echo "<tr>";
  foreach ($row as $value) {
      echo "<td>$value</td>";
  }
  echo "</tr>";
}
echo "</table>";
} else {
echo "Aucun résultat trouvé.";
}

