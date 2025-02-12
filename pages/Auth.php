<?php
require_once "User.php";

class Auth {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function login($username, $password) {
        $user = $this->user->getUserByUsername($username);

        if ($user && password_verify($password, $user["password"])) {
            return ["username" => $user["username"], "role" => $user["role"]];
        }
        return false;
    }
}
?>
