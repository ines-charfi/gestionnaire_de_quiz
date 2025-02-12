<?php
session_start();
require_once "Auth.php";
require_once "db.php";

$auth = new Auth($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = $auth->login($username, $password);

    if ($user) {
        $_SESSION["user"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $_SESSION["error"] = "Identifiants incorrects.";
        header("Location: login.php");
        exit();
    }
}
?>

