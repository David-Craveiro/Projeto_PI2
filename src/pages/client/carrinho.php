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
    <h1 class="section-title">Meu Carrinho</h1>
    
    <?php if(empty($items)): ?>
        <div class="empty-cart-message">
            <i class="fas fa-shopping-cart" style="font-size: 4rem; color: var(--cor-texto-suave); margin-bottom: 1.5rem;"></i>
            <h2>Seu carrinho está vazio!</h2>
            <p>Adicione produtos ao seu carrinho para continuar comprando.</p>
            <a href="/src/pages/client/index.php" class="btn btn-primary">Ver Produtos</a>
        </div>
    <?php else: ?>
        <div class="cart-content">
            <div class="cart-items">
                <?php foreach($items as $it): ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="<?php echo htmlspecialchars($it['image']); ?>" alt="<?php echo htmlspecialchars($it['name']); ?>">
                    </div>
                    <div class="cart-item-info">
                        <h4><?php echo htmlspecialchars($it['name']); ?></h4>
                        <p class="item-price">R$ <?php echo number_format($it['price'],2,',','.'); ?></p>
                    </div>
                    <div class="cart-item-quantity">
                        <span class="quantity-label">Qtd:</span>
                        <span class="quantity-value"><?php echo $it['quantity']; ?></span>
                    </div>
                    <div class="cart-item-subtotal">
                        <span class="subtotal-label">Subtotal</span>
                        <span class="subtotal-value">R$ <?php echo number_format($it['subtotal'],2,',','.'); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h3>Resumo do Pedido</h3>
                <div class="divider"></div>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>R$ <?php echo number_format($total,2,',','.'); ?></span>
                </div>
                <div class="summary-row">
                    <span>Frete</span>
                    <span>Grátis</span>
                </div>
                <div class="divider"></div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>R$ <?php echo number_format($total,2,',','.'); ?></span>
                </div>
                <form method="post" action="/src/actions/checkout.php">
                    <button class="btn btn-accent" type="submit">Finalizar Compra</button>
                </form>
                <a href="/src/pages/client/index.php" class="btn btn-secondary">Continuar Comprando</a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
