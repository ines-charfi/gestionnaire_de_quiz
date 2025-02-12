<?php
session_start();
require_once "User.php";
require_once "db.php";

// Vérification du rôle
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

$user = new User($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"]; // admin ou user

    if ($user->register($username, $password, $role)) {
        echo "Utilisateur ajouté avec succès !";
    } else {
        echo "Erreur : ce nom d'utilisateur existe déjà.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
</head>
<body>
    <h2>Ajouter un utilisateur</h2>
    <form method="POST">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <label>Rôle :</label>
        <select name="role">
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
        </select><br>

        <button type="submit">Créer</button>
    </form>
    <a href="admin_dashboard.php">Retour au tableau de bord</a>
</body>
</html>
