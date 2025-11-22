<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireLogin();

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: /src/pages/client/carrinho.php');
    exit;
}

$pdo->beginTransaction();
try {
    $total = 0;
    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $rows = queryAll("SELECT * FROM products WHERE id IN ($placeholders)", $ids);
    foreach ($rows as $r) {
        $total += $r['price'] * $cart[$r['id']];
    }
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (?,?)');
    $stmt->execute([$_SESSION['user_id'], $total]);
    $orderId = $pdo->lastInsertId();
    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)');
    foreach ($rows as $r) {
        $qty = $cart[$r['id']];
        $stmt->execute([$orderId, $r['id'], $qty, $r['price']]);
    }
    $pdo->commit();
    unset($_SESSION['cart']);
    header('Location: /src/pages/client/confirmacao.php');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    die('Erro ao finalizar pedido: ' . $e->getMessage());
}
