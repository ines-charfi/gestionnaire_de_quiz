<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'quiz_database';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
    // Méthode pour préparer une requête SQL
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    // Méthode pour exécuter une requête sans paramètre
    public function execute($sql) {
        return $this->conn->exec($sql);
    }

    // Méthode pour exécuter une requête avec des paramètres
    public function executeWithParams($sql, $params) {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

}
?>
