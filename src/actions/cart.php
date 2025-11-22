<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /src/pages/client/index.php');
    exit;
}

$product_id = (int)($_POST['product_id'] ?? 0);
$quantity = max(1, (int)($_POST['quantity'] ?? 1));

if ($product_id <= 0) {
    header('Location: /src/pages/client/index.php');
    exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (!isset($_SESSION['cart'][$product_id])) $_SESSION['cart'][$product_id] = 0;
$_SESSION['cart'][$product_id] += $quantity;

header('Location: /src/pages/client/carrinho.php');
exit;
