<?php
session_start();
var_dump($_SESSION);

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
    <title>Panel Admin</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Panel Admin de Quiz_Night</h1>
        <nav>
            <a href="index.php">Retour à l'accueil</a>
            <a href="ajouter_quiz.php">Créer un quiz</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Liste des Quizs</h2>
            <div class="quiz-list">
                <?php foreach ($quizzes as $quizItem): ?>
                    <div class="quiz-item">
                        <img src="../images/<?php echo $quizItem['image']; ?>" alt="<?php echo $quizItem['titre']; ?>"
                            class="quiz-image">
                        <h3><?php echo $quizItem['titre']; ?></h3>
                        <p><?php echo $quizItem['description']; ?></p>
                        <a href="edit_quiz.php?id=<?php echo $quizItem['id']; ?>" class="edit-button">Modifier</a>
                        <a href="delete_quiz.php?id=<?php echo $quizItem['id']; ?>" class="delete-button">Supprimer</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>


    <footer>
        <p>&copy; 2025 Quiz_Night tous droits sont réservés</p>
    </footer>
</body>

</html>