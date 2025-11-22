<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
if (!isLogged() || empty($_SESSION['is_admin'])) {
    header('Location: /src/pages/client/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/pages/admin/admin-produtos.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
    $pdo->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
}

header('Location: /src/pages/admin/admin-produtos.php');
exit;
