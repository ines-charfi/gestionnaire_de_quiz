<?php
session_start();
include './classes/database.php';
include './classes/Quiz.php';
include './classes/Question.php';
include './classes/Reponse.php';

// Connexion à la base de données
$db = (new Database())->connect();
$quiz = new Quiz($db);
$question = new Question($db);
$answer = new Answer($db);

// Vérification si l'ID du quiz existe
if (isset($_GET['id'])) {
    $quizId = $_GET['id'];
    
    // Lire les questions associées au quiz
    $questions = $question->readByQuiz($quizId);  // Passer directement l'ID du quiz sans nommer le paramètre

    // Supprimer toutes les réponses associées à chaque question
    foreach ($questions as $q) {
        $answer->deleteByQuestion($q['id']);  // Assurez-vous que la méthode deleteByQuestion existe dans la classe Answer
    }

    // Supprimer les questions associées au quiz
    foreach ($questions as $q) {
        $question->delete($q['id']);  // Assurez-vous que la méthode delete existe dans la classe Question
    }

    // Supprimer le quiz
    $quiz->delete($quizId);  // Suppression du quiz

    // Rediriger vers la page admin après la suppression
    header('Location: admin.php');  
    exit();
}
?>
