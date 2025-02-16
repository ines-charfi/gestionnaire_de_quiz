<?php
require_once "db.php";

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    public function getUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

