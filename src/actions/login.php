<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/pages/client/login.php');
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$user = queryOne('SELECT * FROM users WHERE email = ?', [$email]);
if ($user && password_verify($password, $user['password'])) {
    loginUser($user);
    header('Location: /src/pages/client/index.php');
    exit;
} else {
    header('Location: /src/pages/client/login.php');
    exit;
}
