<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (!isLogged() || empty($_SESSION['is_admin'])) {
    header('Location: /src/pages/client/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/pages/admin/admin-usuarios.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id <= 0) {
    $msg = 'ID inválido';
    header('Location: /src/pages/admin/admin-usuarios.php?msg=' . urlencode($msg));
    exit;
}

// não permitir alterar o próprio nível de admin (para evitar se desconfigurar)
if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
    $msg = 'Você não pode alterar seu próprio nível de administrador';
    header('Location: /src/pages/admin/admin-usuarios.php?msg=' . urlencode($msg));
    exit;
}

$user = queryOne('SELECT id, is_admin FROM users WHERE id = ?', [$id]);
if (!$user) {
    $msg = 'Usuário não encontrado';
    header('Location: /src/pages/admin/admin-usuarios.php?msg=' . urlencode($msg));
    exit;
}

$new = empty($user['is_admin']) ? 1 : 0;
global $pdo;
$stmt = $pdo->prepare('UPDATE users SET is_admin = ? WHERE id = ?');
try {
    $stmt->execute([$new, $id]);
    $msg = $new ? 'Usuário promovido a administrador' : 'Privilégio de administrador removido';
} catch (Exception $e) {
    $msg = 'Erro ao atualizar usuário: ' . $e->getMessage();
}

header('Location: /src/pages/admin/admin-usuarios.php?msg=' . urlencode($msg));
exit;
