<?php
session_start();
require_once "Auth.php";
require_once "db.php";

$auth = new Auth($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = $auth->login($username, $password);

    $_SESSION['user'] = $user;

} else {
    $_SESSION["error"] = "Identifiants incorrects.";
    header("Location: index.php");
    exit();
}

?>