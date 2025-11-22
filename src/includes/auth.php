<?php
session_start();
require_once __DIR__ . '/db.php';

function isLogged() {
    return !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLogged()) {
        header('Location: /src/pages/client/login.php');
        exit;
    }
}

function loginUser($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['is_admin'] = !empty($user['is_admin']);
}

function logout() {
    session_unset();
    session_destroy();
}
