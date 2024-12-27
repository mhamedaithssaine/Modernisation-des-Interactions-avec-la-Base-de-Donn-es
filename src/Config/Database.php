<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $db_name = "joueurs";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "Connexion réussie à la base de données.";
} else {
    echo "Impossible de se connecter à la base de données.";
}
