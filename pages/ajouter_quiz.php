<?php
session_start();
include './classes/database.php';
include './classes/Quiz.php';
include './classes/Question.php';
include './classes/Reponse.php';
include_once './classes/uploadImage.php';  // Inclure le fichier correctement une seule fois

$quiz = new Quiz($db);
$question = new Question($db);
$answer = new Answer($db);

// Vérification si l'ID du quiz existe (pour la mise à jour)
if (isset($_GET['id'])) {
    $quizData = $quiz->readOne($_GET['id']);
    $questions = $question->readByQuiz($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du quiz
    $id = $_GET['id'] ?? null;
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image']['size'] > 0 ? uploadImage($_FILES['image']) : ($quizData['image'] ?? null);

    // Si l'image renvoie une erreur, on arrête le traitement
    if (strpos($image, 'Désolé') !== false) {
        echo $image;
        exit();
    }

    // Création ou mise à jour du quiz
    if ($id) {
        // Mise à jour du quiz
        $quiz->id = $id;
        $quiz->title = $title;
        $quiz->description = $description;
        $quiz->image = $image;
        $quiz->user_id = $_SESSION['id_user']; // Assurez-vous que la session contient l'ID de l'utilisateur connecté

        // Appeler la méthode de mise à jour
        if (!$quiz->update($id, $title, $description, $image)) {
            echo "Une erreur est survenue lors de la mise à jour du quiz.";
            exit();
        }
    } else {
        // Création du quiz
        $quiz->title = $title;
        $quiz->description = $description;
        $quiz->image = $image;
        $quiz->user_id = $_SESSION['id_user'];

        // Appeler la méthode create pour insérer dans la base de données
        $quizId = $quiz->create();  // Passer uniquement les paramètres nécessaires
        if (!$quizId) {
            echo "Une erreur est survenue lors de la création du quiz.";
            exit();
        }
    }

    // Ajouter les questions et les réponses
    for ($i = 1; $i <= 3; $i++) {
        $questionText = htmlspecialchars($_POST['question_' . $i]);
        $correctAnswerIndex = $_POST['correct_answer_' . $i];

        // Création de la question
        $question = new Question($db);
        $question->create($quizId, $questionText);  // Ajouter le quizId à la création de la question

        // Ajouter les réponses
        for ($j = 1; $j <= 3; $j++) {
            $answerText = htmlspecialchars($_POST['answer_' . $i . '_' . $j]);
            $isCorrect = ($correctAnswerIndex == $j) ? 1 : 0;  // Marquer la réponse correcte
            $answer = new Answer($db);
            $answer->create($question->id, $answerText, $isCorrect);  // Passer l'ID de la question créée
        }
    }

    // Rediriger vers la page admin après la modification ou création du quiz
    header('Location: admin.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Créer un Quiz</h1>
        <nav>
            <a href="admin.php">Retour au panel admin</a>
        </nav>
    </header>

    <main>
        <section>
            <form action="ajouter_quiz.php" method="POST" enctype="multipart/form-data">
                <label for="title">Titre du Quiz:</label><br>
                <input type="text" id="title" name="title" required><br>

                <label for="description">Description du Quiz:</label><br>
                <textarea id="description" name="description" required></textarea><br>

                <label for="image">Image du Quiz:</label><br>
                <input type="file" id="image" name="image" accept="image/*"><br>

                <hr>
                <h3>Questions et Réponses</h3>

                <!-- Question 1 -->
                <label for="question_1">Question 1:</label><br>
                <input type="text" id="question_1" name="question_1" required><br>

                <!-- Réponses Question 1 -->
                <label for="answer_1_1">Réponse 1:</label><br>
                <input type="text" id="answer_1_1" name="answer_1_1" required><br>
                <label for="answer_1_2">Réponse 2:</label><br>
                <input type="text" id="answer_1_2" name="answer_1_2" required><br>
                <label for="answer_1_3">Réponse 3:</label><br>
                <input type="text" id="answer_1_3" name="answer_1_3" required><br>

                <label for="correct_answer_1">Réponse correcte:</label><br>
                <select name="correct_answer_1" id="correct_answer_1">
                    <option value="1">Réponse 1</option>
                    <option value="2">Réponse 2</option>
                    <option value="3">Réponse 3</option>
                </select><br>

                <hr>

                <!-- Question 2 -->
                <label for="question_2">Question 2:</label><br>
                <input type="text" id="question_2" name="question_2" required><br>

                <!-- Réponses Question 2 -->
                <label for="answer_2_1">Réponse 1:</label><br>
                <input type="text" id="answer_2_1" name="answer_2_1" required><br>
                <label for="answer_2_2">Réponse 2:</label><br>
                <input type="text" id="answer_2_2" name="answer_2_2" required><br>
                <label for="answer_2_3">Réponse 3:</label><br>
                <input type="text" id="answer_2_3" name="answer_2_3" required><br>

                <label for="correct_answer_2">Réponse correcte:</label><br>
                <select name="correct_answer_2" id="correct_answer_2">
                    <option value="1">Réponse 1</option>
                    <option value="2">Réponse 2</option>
                    <option value="3">Réponse 3</option>
                </select><br>

                <hr>

                <!-- Question 3 -->
                <label for="question_3">Question 3:</label><br>
                <input type="text" id="question_3" name="question_3" required><br>

                <!-- Réponses Question 3 -->
                <label for="answer_3_1">Réponse 1:</label><br>
                <input type="text" id="answer_3_1" name="answer_3_1" required><br>
                <label for="answer_3_2">Réponse 2:</label><br>
                <input type="text" id="answer_3_2" name="answer_3_2" required><br>
                <label for="answer_3_3">Réponse 3:</label><br>
                <input type="text" id="answer_3_3" name="answer_3_3" required><br>

                <label for="correct_answer_3">Réponse correcte:</label><br>
                <select name="correct_answer_3" id="correct_answer_3">
                    <option value="1">Réponse 1</option>
                    <option value="2">Réponse 2</option>
                    <option value="3">Réponse 3</option>
                </select><br>

                <hr>
                <button type="submit">Créer le Quiz</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 QuizSite</p>
    </footer>
</body>
</html>
