<?php
class Quiz {
    private $conn;
    private $table = 'quizzes';

    public $id;
    public $title;
    public $description;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un quiz
    public function create() {
        $query = "INSERT INTO {$this->table} (titre, description, image) VALUES (:titre, :description, :image)";
        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':titre', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);

        // Exécution
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lire tous les quizs
    public function read() {
        $query = 'SELECT * FROM quizzes';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    // Lire un quiz par ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un quiz
    public function update($id, $title, $description, $image) {
        $query = "UPDATE " . $this->table . " SET titre = :titre, description = :description, image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titre', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);

        // Exécution
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer un quiz
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

    // Méthode pour supprimer un quiz avec ses questions
    public function deleteWithQuestions($quizId) {
        // Supprimer les réponses liées aux questions
        $queryDeleteAnswers = "DELETE FROM answers WHERE id_question IN (SELECT id FROM questions WHERE id_quizzes = :quizId)";
        $stmt = $this->conn->prepare($queryDeleteAnswers);
        $stmt->bindParam(":quizId", $quizId);
        $stmt->execute();

        // Supprimer les questions associées au quiz
        $queryDeleteQuestions = "DELETE FROM questions WHERE id_quizzes = :quizId";
        $stmt = $this->conn->prepare($queryDeleteQuestions);
        $stmt->bindParam(":quizId", $quizId);
        $stmt->execute();

        // Enfin, supprimer le quiz
        $queryDeleteQuiz = "DELETE FROM quizzes WHERE id = :quizId";
        $stmt = $this->conn->prepare($queryDeleteQuiz);
        $stmt->bindParam(":quizId", $quizId);
        $stmt->execute();
    }
}

?>
