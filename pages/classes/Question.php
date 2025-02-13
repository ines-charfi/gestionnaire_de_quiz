<?php
class Question {
    private $conn;
    private $table = 'questions';

    public $id;
    public $quizzes_id;
    public $text;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer une question
    public function create() {
        $query = "INSERT INTO " . $this->table . " (id_quizzes, description) VALUES (:id_quizzes, :description)";
        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':id_quizzes', $this->quizzes_id);
        $stmt->bindParam(':description', $this->text);

        // Exécution
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lire les questions par quiz
    public function readByQuiz($quizzes_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_quizzes = :id_quizzes";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_quizzes', $quizzes_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une question
    public function update($id, $text) {
        $query = "UPDATE " . $this->table . " SET description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $text);

        // Exécution
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer une question
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Exécution
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
