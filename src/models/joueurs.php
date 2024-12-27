<?php
require_once '../Config/database.php';

class Joueurs {
    public $conn;
    private $table_name = "joueurs";

    public $id;
    public $name;
    public $img;
    public $position;
    public $rating;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertRecord($data) {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO " . $this->table_name . " ($columns) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "N'inserer pas des donner !";
            return false;
        }

        $stmt->execute(array_values($data));
        return $stmt->rowCount() > 0;
    }

    public function updateRecord($data, $id) {
        $args = array();
        foreach ($data as $key => $value) {
            $args[] = "$key = ?";
        }
        $sql = "UPDATE " . $this->table_name . " SET " . implode(',', $args) . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Erreur dans la declaration  : " . $this->conn->errorInfo();
            return false;
        }

        $params = array_values($data);
        $params[] = $id;
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function deleteRecord($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Erreur dans la declaration preparee : " . $this->conn->errorInfo();
            return false;
        }

        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function selectRecords($columns = "*", $where = null) {
        $sql = "SELECT $columns FROM " . $this->table_name;
        if ($where !== null) {
            $sql .= " WHERE $where";
        }
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Erreur dans la declaration preparee  : " . $this->conn->errorInfo();
            return false;
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Usage example:

$db = new Database();
$conn = $db->getConnection();

$joueurs = new Joueurs($conn);

// Insert example
$insertData = array('name' => 'Khalid', 'img' => 'khalid.jpg', 'position' => 'CM', 'rating' => 85);
if ($joueurs->insertRecord($insertData)) {
    echo "inserer des donnes avec succees";
} else {
    echo "Echec d'insertion des donnees !";
}

// Update example
$updateData = array('name' => 'Foulan', 'img' => 'Reida.jpg', 'position' => 'SA', 'rating' => 90);
if ($joueurs->updateRecord($updateData, 1)) {
    echo "modification avec succees";
} else {
    echo "Echec de modification !";
}

// Delete example
if ($joueurs->deleteRecord(1)) {
    echo " supprime avec succees.";
} else {
    echo "Echec de la suppression ";
}

// Select example
$selectResult = $joueurs->selectRecords('id, name, img, position, rating', 'id = 1');
foreach ($selectResult as $row) {
    print_r($row);
}

?>