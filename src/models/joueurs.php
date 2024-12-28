<?php
require_once 'src/Config/database.php';

class Joueurs {
    public $conn;
  
    public $id;
    public $name;
    public $img;
    public $position;
    public $rating;

    public function __construct($db) {
        $this->conn = $db;
        
    }

    public function insertRecord($table_name,$data) {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO " . $table_name . " ($columns) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "N'inserer pas des donner !";
            return false;
        }

        $stmt->execute(array_values($data));
        return $stmt->rowCount() > 0;
    }

    public function updateRecord($table_name,$data, $id) {
        $args = array();
        
        foreach ($data as $key => $value) {
            $args[] = "$key = ?";
        }
        $sql = "UPDATE " . $table_name . " SET " . implode(',', $args) . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Erreur dans la declaration  : " . $this->conn->errorInfo();
            return false;
        }
        $types = str_repeat('s', count($data) + 1);
        $params = array_values($data);
        $params[] = $id;
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function deleteRecord($table_name,$id) {
        $sql = "DELETE FROM $table_name  WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Erreur dans la declaration preparee : " . $this->conn->errorInfo();
            return false;
        }

        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public function selectRecords($table_name,$columns = "*", $where = null) {
        $sql = "SELECT $columns FROM $table_name";
        if ($where !== null) {
            $sql .= " WHERE $where";
        }
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Erreur dans la déclaration préparée : " . implode(" ", $this->conn->errorInfo());
            return false;
        }


        $stmt->execute();
        
        return   $stmt->fetchALL(PDO::FETCH_ASSOC);
        ;
    }
}






?>