<?php
include_once 'models/User.php';

class UserController {
    public static function authenticate($username, $password) {
        return User::getByUsernameAndPassword($username, $password);
    }

    public static function getUserId($username) {
        return User::getByUsername($username)['id'];
    }

    public static function isAdmin($username) {
        return $username == 'admin';
    }
}
?>
