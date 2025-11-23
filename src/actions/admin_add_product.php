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

$name = trim($_POST['name'] ?? '');
$image = trim($_POST['image'] ?? '');
$price = $_POST['price'] ?? '';
$description = trim($_POST['description'] ?? '');
$stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;

$errors = [];
if ($name === '') $errors[] = 'Nome é obrigatório.';
if ($price === '' || !is_numeric($price)) $errors[] = 'Preço inválido.';

if (!empty($errors)) {
    // Para simplicidade, redireciona de volta (poderíamos mostrar mensagens)
    header('Location: /src/pages/admin/admin-produtos.php');
    exit;
}

$stmt = $pdo->prepare('INSERT INTO products (name, price, image, description, stock) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$name, (float)$price, $image, $description, $stock]);

header('Location: /src/pages/admin/admin-produtos.php');
exit;
