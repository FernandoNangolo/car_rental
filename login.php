<?php
include 'controllers/UserController.php';
include 'views/header.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = UserController::authenticate($username, $password);

    if ($user) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $loginError = "Invalid login";
    }
}

include 'views/login.php';
include 'views/footer.php';
?>
