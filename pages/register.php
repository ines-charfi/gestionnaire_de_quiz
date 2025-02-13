<?php
require_once "User.php";
require_once "db.php";

$user = new User($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Tous les nouveaux utilisateurs ont le rôle "user" par défaut
    $role = "user";

    if ($user->register($username, $password, $role)) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : ce nom d'utilisateur existe déjà.";
    }
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <h2><a href='login.php'>Connectez-vous ici</a></h2>
    <h2>Inscription</h2>
    <form method="POST">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">S'inscrire</button>
    </form>
    
    <footer>
        <p>&copy; 2025 Quiz_Night tous droits sont réservés</p>
    </footer>
</body>
</html>
