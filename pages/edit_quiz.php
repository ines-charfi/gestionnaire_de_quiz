<?php
include './classes/database.php';
include './classes/Quiz.php';
include './classes/Question.php';
include './classes/Reponse.php';


// Connexion à la base de données
$db = (new Database())->connect();
$quiz = new Quiz($db);
$question = new Question($db);
$answer = new Answer($db);

// Fonction pour télécharger l'image
function uploadImage($file)
{
    $targetDir = "../images/";
    $targetFile = $targetDir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $targetFile);
    return $targetFile;
}

// Vérification si l'ID du quiz existe
if (isset($_GET['id'])) {
    $quizData = $quiz->readOne($_GET['id']);
    $questions = $question->readByQuiz($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du quiz
    $id = $_GET['id'];
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image']['size'] > 0 ? uploadImage($_FILES['image']) : $quizData['image'];

    // Mettre à jour le quiz
    $quiz->update($id, $title, $description, $image);

    // Mettre à jour les questions et réponses
    for ($i = 1; $i <= 3; $i++) {
        // Vérifier si la question existe avant de l'utiliser
        if (isset($questions[$i - 1])) {
            $questionText = htmlspecialchars($_POST['question_' . $i]);
            $correctAnswerIndex = $_POST['correct_answer_' . $i];
            
            // Mise à jour de la question
            $questionId = $question->update($questions[$i - 1]['id'], $questionText);

            // Vérifier si les réponses existent avant de les mettre à jour
            if (isset($questions[$i - 1]['answers'])) {
                for ($j = 1; $j <= 3; $j++) {
                    if (isset($questions[$i - 1]['answers'][$j - 1])) {
                        $answerText = htmlspecialchars($_POST['answer_' . $i . '_' . $j]);
                        $isCorrect = ($correctAnswerIndex == $j) ? 1 : 0;
                        $answer->update($questions[$i - 1]['answers'][$j - 1]['id'], $answerText, $isCorrect);
                    }
                }
            }
        }
    }

    header('Location: admin.php');  // Rediriger vers la page admin après la modification du quiz
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Modifier le Quiz</h1>
        <nav>
            <a href="admin.php">Retour au panel admin</a>
        </nav>
    </header>

    <main>
        <section>
            <form action="edit_quiz.php?id=<?php echo $quizData['id']; ?>" method="POST" enctype="multipart/form-data">
                <label for="title">Titre du Quiz:</label><br>
                <input type="text" id="title" name="title" value="<?php echo $quizData['titre']; ?>" required><br>

                <label for="description">Description du Quiz:</label><br>
                <textarea id="description" name="description"
                    required><?php echo $quizData['description']; ?></textarea><br>

                <label for="image">Image du Quiz:</label><br>
                <input type="file" id="image" name="image" accept="images/*"><br>

                <hr>
                <h3>Questions et Réponses</h3>

                <!-- Question 1 -->
                <label for="question_1">Question 1:</label><br>
                <input type="text" id="question_1" name="question_1" value="<?php echo isset($questions[0]) ? $questions[0]['question'] : ''; ?>" required><br>

                <!-- Réponses Question 1 -->
                <label for="answer_1_1">Réponse 1:</label><br>
                <input type="text" id="answer_1_1" name="answer_1_1" value="<?php echo isset($questions[0]['answers'][0]) ? $questions[0]['answers'][0]['reponse'] : ''; ?>" required><br>
                <label for="answer_1_2">Réponse 2:</label><br>
                <input type="text" id="answer_1_2" name="answer_1_2" value="<?php echo isset($questions[0]['answers'][1]) ? $questions[0]['answers'][1]['reponse'] : ''; ?>" required><br>
                <label for="answer_1_3">Réponse 3:</label><br>
                <input type="text" id="answer_1_3" name="answer_1_3" value="<?php echo isset($questions[0]['answers'][2]) ? $questions[0]['answers'][2]['reponse'] : ''; ?>" required><br>

                <label for="correct_answer_1">Réponse correcte:</label><br>
                <select name="correct_answer_1" id="correct_answer_1">
                    <option value="1" <?php echo (isset($questions[0]['answers'][0]) && $questions[0]['answers'][0]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 1</option>
                    <option value="2" <?php echo (isset($questions[0]['answers'][1]) && $questions[0]['answers'][1]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 2</option>
                    <option value="3" <?php echo (isset($questions[0]['answers'][2]) && $questions[0]['answers'][2]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 3</option>
                </select><br>

                <hr>

                <!-- Question 2 -->
                <label for="question_2">Question 2:</label><br>
                <input type="text" id="question_2" name="question_2" value="<?php echo isset($questions[1]) ? $questions[1]['question'] : ''; ?>" required><br>

                <!-- Réponses Question 2 -->
                <label for="answer_2_1">Réponse 1:</label><br>
                <input type="text" id="answer_2_1" name="answer_2_1" value="<?php echo isset($questions[1]['answers'][0]) ? $questions[1]['answers'][0]['reponse'] : ''; ?>" required><br>
                <label for="answer_2_2">Réponse 2:</label><br>
                <input type="text" id="answer_2_2" name="answer_2_2" value="<?php echo isset($questions[1]['answers'][1]) ? $questions[1]['answers'][1]['reponse'] : ''; ?>" required><br>
                <label for="answer_2_3">Réponse 3:</label><br>
                <input type="text" id="answer_2_3" name="answer_2_3" value="<?php echo isset($questions[1]['answers'][2]) ? $questions[1]['answers'][2]['reponse'] : ''; ?>" required><br>

                <label for="correct_answer_2">Réponse correcte:</label><br>
                <select name="correct_answer_2" id="correct_answer_2">
                    <option value="1" <?php echo (isset($questions[1]['answers'][0]) && $questions[1]['answers'][0]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 1</option>
                    <option value="2" <?php echo (isset($questions[1]['answers'][1]) && $questions[1]['answers'][1]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 2</option>
                    <option value="3" <?php echo (isset($questions[1]['answers'][2]) && $questions[1]['answers'][2]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 3</option>
                </select><br>

                <hr>

                <!-- Question 3 -->
                <label for="question_3">Question 3:</label><br>
                <input type="text" id="question_3" name="question_3" value="<?php echo isset($questions[2]) ? $questions[2]['question'] : ''; ?>" required><br>

                <!-- Réponses Question 3 -->
                <label for="answer_3_1">Réponse 1:</label><br>
                <input type="text" id="answer_3_1" name="answer_3_1" value="<?php echo isset($questions[2]['answers'][0]) ? $questions[2]['answers'][0]['reponse'] : ''; ?>" required><br>
                <label for="answer_3_2">Réponse 2:</label><br>
                <input type="text" id="answer_3_2" name="answer_3_2" value="<?php echo isset($questions[2]['answers'][1]) ? $questions[2]['answers'][1]['reponse'] : ''; ?>" required><br>
                <label for="answer_3_3">Réponse 3:</label><br>
                <input type="text" id="answer_3_3" name="answer_3_3" value="<?php echo isset($questions[2]['answers'][2]) ? $questions[2]['answers'][2]['reponse'] : ''; ?>" required><br>

                <label for="correct_answer_3">Réponse correcte:</label><br>
                <select name="correct_answer_3" id="correct_answer_3">
                    <option value="1" <?php echo (isset($questions[2]['answers'][0]) && $questions[2]['answers'][0]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 1</option>
                    <option value="2" <?php echo (isset($questions[2]['answers'][1]) && $questions[2]['answers'][1]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 2</option>
                    <option value="3" <?php echo (isset($questions[2]['answers'][2]) && $questions[2]['answers'][2]['correct'] == 1) ? 'selected' : ''; ?>>Réponse 3</option>
                </select><br>

                <hr>

                <button type="submit">Mettre à jour le Quiz</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 QuizSite</p>
    </footer>
</body>

</html>
