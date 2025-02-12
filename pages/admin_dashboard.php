<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Admin - Tableau de bord</title>
</head>
<body>
    <h2>Bienvenue Admin, <?php echo htmlspecialchars($_SESSION["user"]); ?> !</h2>
    <p>Gérez les quizz ici.</p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
