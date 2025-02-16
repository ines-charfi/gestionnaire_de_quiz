<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "user") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateur - Tableau de bord</title>
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION["user"]); ?> !</h2>
    <p>Vous êtes connecté en tant qu'utilisateur.</p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
