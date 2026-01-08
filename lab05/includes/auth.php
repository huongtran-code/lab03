<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'users.php';

function login($username, $password) {
    global $users;
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['user'] = $username;
        return true;
    }
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function logout() {
    unset($_SESSION['user']);
    session_destroy();
}