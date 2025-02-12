<?php
include './classes/Database.php';
include './classes/Quiz.php';
include './classes/Question.php';
include './classes/Reponse.php';

// Connexion à la base de données
$db = (new Database())->connect();
$quiz = new Quiz($db);
$question = new Question($db);
$answer = new Answer($db);


if (isset($_GET['id'])) {
    $quizData = $quiz->readOne($_GET['id']);
    if (!$quizData) {  // Vérifier si $quizData est valide
        die("Quiz non trouvé.");
    }
    $questions = $question->readByQuiz($_GET['id']);
} else {
    die("ID du quiz manquant.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $index => $q) {
        if (isset($_POST['answer_' . ($index + 1)])) {
            $selectedAnswer = $_POST['answer_' . ($index + 1)];
            $correctAnswer = $answer->getCorrectAnswer($q['id']);
            if ($selectedAnswer == $correctAnswer['id']) {
                $score++;
            }
        }
    }
    echo "Votre score: " . $score . " sur " . count($questions);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouer au Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <h1><?php echo isset($quizData['titre']) ? htmlspecialchars($quizData['titre']) : 'Quiz non trouvé'; ?></h1>

        <nav>
            <a href="index.php">Retour à l'accueil</a>
        </nav>
    </header>

    <main>
        <form action="play_quiz.php?id=<?php echo $quizData['id']; ?>" method="POST">
            <?php foreach ($questions as $index => $q): ?>
                <fieldset>
                    <legend><?php echo $q['description']; ?></legend><br>
                    <?php $answers = $answer->readByQuestion($q['id']); ?><br>
                    <?php foreach ($answers as $a): ?>
                        <div class="answer">
                            <label>
                                <input type="radio" name="answer_<?php echo $index + 1; ?>" value="<?php echo $a['id']; ?>">
                                <?php echo $a['description']; ?><br>
                            </label><br>
                        </div><br>
                    <?php endforeach; ?>
                </fieldset>
            <?php endforeach; ?>
            <button type="submit">Soumettre</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 QuizSite</p>
    </footer>
</body>
</html>
