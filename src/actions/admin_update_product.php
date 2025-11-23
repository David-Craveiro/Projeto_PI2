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

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name'] ?? '');
$image = trim($_POST['image'] ?? '');
$price = $_POST['price'] ?? '';

if ($id <= 0 || $name === '' || $price === '' || !is_numeric($price)) {
    $msg = 'Dados inválidos.';
    header('Location: /src/pages/admin/admin-produtos.php?msg=' . urlencode($msg));
    exit;
}

try {
    $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, image = ? WHERE id = ?');
    $stmt->execute([$name, (float)$price, $image, $id]);
    $msg = 'Produto atualizado com sucesso.';
} catch (Exception $e) {
    $msg = 'Erro ao atualizar produto: ' . $e->getMessage();
}

header('Location: /src/pages/admin/admin-produtos.php?msg=' . urlencode($msg));
exit;
