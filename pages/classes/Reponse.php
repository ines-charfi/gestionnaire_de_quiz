<?php
class Answer {
    private $conn;
    private $table = 'reponses';

    public $id;
    public $question_id;
    public $text;
    public $is_correct;

    public function __construct($db) {
        $this->conn = $db;
    }

  // Créer une réponse
  public function create($questionId, $answerText, $isCorrect) {
    $query = "INSERT INTO reponses (questions_id, description, is_correct) VALUES (:questions_id, :description, :is_correct)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':question_id', $questionId);
    $stmt->bindParam(':description', $answerText);
    $stmt->bindParam(':is_correct', $isCorrect);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}
   

    // Lire les réponses par question
    public function readByQuestion($question_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE questions_id = :questions_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':questions_id', $question_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une réponse
    public function update($id, $text, $is_correct) {
        $query = "UPDATE " . $this->table . " SET description = :description, is_correct = :is_correct WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $text);
        $stmt->bindParam(':is_correct', $is_correct);

        // Exécution
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer une réponse
    public function deleteByQuestion($questionId) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE questions_id = :questions_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':questions_id', $questionId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtenir la réponse correcte
    public function getCorrectAnswer($question_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE questions_id = :questions_id AND is_correct = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':questions_id', $question_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}


?>
