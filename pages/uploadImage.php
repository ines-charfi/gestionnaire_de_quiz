<?php
include './classes/Database.php';
include './classes/Quiz.php';
include './classes/Question.php';
include './classes/Reponse.php';



// Connexion à la base de données
$db = (new Database())->connect();

// Fonction pour gérer l'upload d'image
function uploadImage($file) {
    $targetDir = "../images/";  // Chemin où les images seront stockées
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle ou une image falsifiée
    if (getimagesize($file["tmp_name"]) === false) {
        return "Ce fichier n'est pas une image.";
    }

    // Vérifier la taille de l'image (limite de 5Mo)
    if ($file["size"] > 5000000) {
        return "Désolé, l'image est trop grande.";
    }

    // Autoriser certains formats d'image
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        return "Désolé, seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
    }

    // Déplacer l'image dans le répertoire cible
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return '../images/' . basename($file["name"]);
    } else {
        return "Désolé, une erreur s'est produite lors de l'upload de l'image.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du quiz
    $title = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    
    // Upload de l'image du quiz
    $image = uploadImage($_FILES['image']);
    if (strpos($image, 'images/') === false) {
        echo $image; // Afficher le message d'erreur si l'upload échoue
        exit();
    }

    // Création du quiz
    $quiz = new Quiz($db);
    $quizId = $quiz->create($title, $description, $image);

    // Ajouter les questions et les réponses pour chaque question
    for ($i = 1; $i <= 3; $i++) {
        $questionText = htmlspecialchars($_POST['question_' . $i]);
        $correctAnswerIndex = $_POST['correct_answer_' . $i];

        // Création de la question
        $question = new Question($db);
        $questionId = $question->create($quizId, $questionText);

        // Ajouter les réponses
        for ($j = 1; $j <= 3; $j++) {
            $answerText = htmlspecialchars($_POST['answer_' . $i . '_' . $j]);
            $isCorrect = ($correctAnswerIndex == $j) ? 1 : 0;  // Marquer la réponse correcte
            $answer = new Answer($db);
            $answer->create($questionId, $answerText, $is_Correct);
        }
    }

    header('Location: admin.php');  // Rediriger vers la page admin après la création du quiz
}
?>

