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

// não permitir deletar a si mesmo
if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
    $msg = 'Você não pode deletar o seu próprio usuário';
    header('Location: /src/pages/admin/admin-usuarios.php?msg=' . urlencode($msg));
    exit;
}

global $pdo;
$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
try {
    $stmt->execute([$id]);
    $msg = 'Usuário deletado com sucesso';
} catch (Exception $e) {
    $msg = 'Erro ao deletar usuário: ' . $e->getMessage();
}

header('Location: /src/pages/admin/admin-usuarios.php?msg=' . urlencode($msg));
exit;
