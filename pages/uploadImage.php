<?php
if (!function_exists('uploadImage')) {
    function uploadImage($file) {
        $targetDir = "images/";  // Dossier pour stocker les images
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Vérifier si le fichier est une image réelle ou non
        if (getimagesize($file["tmp_name"]) === false) {
            return "Ce fichier n'est pas une image.";
        }

        // Vérifier la taille de l'image
        if ($file["size"] > 5000000) {  // 5 Mo
            return "Désolé, l'image est trop grande.";
        }

        // Autoriser certains formats d'image
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            return "Désolé, seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
        }

        // Déplacer l'image vers le dossier cible
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;  // Retourner le chemin de l'image téléchargée
        } else {
            return "Désolé, une erreur s'est produite lors de l'upload de l'image.";
        }
    }
}
?>
