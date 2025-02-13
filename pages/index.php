<?php
session_start();
include './classes/Database.php';
include './classes/Quiz.php';

// Connexion à la base de données

$db = (new Database())->connect();
$quiz = new Quiz($db);
$quizzes = $quiz->read();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><b>Bienvenue sur le site de Quiz_Night</b></h1>
        <nav>
        <a href="login.php" class="btn">Login</a> &emsp;
        <a href="register.php" class="btn">Register</a>
          
        </nav>
    </header>

    <main>
        <section>
            <?php if (count($quizzes) > 0): ?>
                <h2>Liste des Quizs</h2>
                <div class="quiz-list">
                    <?php foreach ($quizzes as $quizItem): ?>
                        <div class="quiz-item">
                            <img src="../images/<?php echo $quizItem['image']; ?>" alt="<?php echo $quizItem['titre']; ?>" class="quiz-image">
                            <h3><?php echo $quizItem['titre']; ?></h3>
                            <p><?php echo $quizItem['description']; ?></p>
                            <a href="play_quiz.php?id=<?php echo $quizItem['id']; ?>" class="play-button">Jouer</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun quiz disponible pour le moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 QuizSite</p>
    </footer>
</body>
</html>
