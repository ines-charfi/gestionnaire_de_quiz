<?php
function uploadImage($file) {
    $targetDir = "images/";
    $targetFile = $targetDir . basename($file["name"]);

    // Vérifier si le fichier est une image réelle ou une image falsifiée
    if (getimagesize($file["tmp_name"]) === false) {
        return "Ce fichier n'est pas une image.";
    }

    // Vérifier la taille de l'image (limite de 5Mo)
    if ($file["size"] > 5000000) {
        return "Désolé, l'image est trop grande.";
    }

    // Autoriser certains formats d'image
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        return "Désolé, seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
    }

    // Déplacer l'image dans le répertoire cible
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    } else {
        return "Désolé, une erreur s'est produite lors de l'upload de l'image.";
    }
}
?>