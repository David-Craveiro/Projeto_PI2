<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';

// Mostrar itens do carrinho (em sessão)
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$items = [];
$total = 0;
if (!empty($cart)) {
    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $rows = queryAll("SELECT * FROM products WHERE id IN ($placeholders)", $ids);
    foreach ($rows as $r) {
        $q = $cart[$r['id']];
        $r['quantity'] = $q;
        $r['subtotal'] = $r['price'] * $q;
        $total += $r['subtotal'];
        $items[] = $r;
    }
}
?>
<main class="container">
    <h1 class="section-title" style="margin-top: 4rem;">Meu Carrinho</h1>
    <?php if(empty($items)): ?>
        <div class="empty-cart-message">
            <h2>Seu carrinho está vazio!</h2>
            <a href="/src/pages/client/index.php" class="btn btn-primary" style="margin-top: 1rem;">Ver produtos</a>
        </div>
    <?php else: ?>
        <table class="cart-table">
            <thead><tr><th>Produto</th><th>Preço</th><th>Quantidade</th><th>Subtotal</th></tr></thead>
            <tbody>
            <?php foreach($items as $it): ?>
                <tr>
                    <td><?php echo htmlspecialchars($it['name']); ?></td>
                    <td>R$ <?php echo number_format($it['price'],2,',','.'); ?></td>
                    <td><?php echo $it['quantity']; ?></td>
                    <td>R$ <?php echo number_format($it['subtotal'],2,',','.'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="cart-total">Total: R$ <?php echo number_format($total,2,',','.'); ?></div>
        <form method="post" action="/src/actions/checkout.php">
            <button class="btn btn-accent" type="submit">Finalizar compra</button>
        </form>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
