<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/pages/client/index.php');
    exit;
}

$action = $_POST['action'] ?? 'add';
$product_id = (int)($_POST['product_id'] ?? 0);

if ($product_id <= 0) {
    header('Location: /src/pages/client/index.php');
    exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Remover item do carrinho
if ($action === 'remove') {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header('Location: /src/pages/client/carrinho.php');
    exit;
}

// Atualizar quantidade do item no carrinho
if ($action === 'update') {
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    header('Location: /src/pages/client/carrinho.php');
    exit;
}

// Adicionar item ao carrinho
$quantity = max(1, (int)($_POST['quantity'] ?? 1));
if (!isset($_SESSION['cart'][$product_id])) $_SESSION['cart'][$product_id] = 0;
$_SESSION['cart'][$product_id] += $quantity;

header('Location: /src/pages/client/carrinho.php');
exit;
