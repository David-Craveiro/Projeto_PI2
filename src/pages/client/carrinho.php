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
                        <span class="quantity-label">Quantidade:</span>
                        <form method="post" action="/src/actions/cart.php" class="quantity-form">
                            <input type="hidden" name="product_id" value="<?php echo $it['id']; ?>">
                            <input type="hidden" name="action" value="update">
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" onclick="decrementQuantity(this)">-</button>
                                <input type="number" name="quantity" value="<?php echo $it['quantity']; ?>" min="1" class="quantity-input" onchange="this.form.submit()">
                                <button type="button" class="quantity-btn" onclick="incrementQuantity(this)">+</button>
                            </div>
                        </form>
                    </div>
                    <div class="cart-item-subtotal">
                        <span class="subtotal-label">Subtotal</span>
                        <span class="subtotal-value">R$ <?php echo number_format($it['subtotal'],2,',','.'); ?></span>
                    </div>
                    <div class="cart-item-actions">
                        <form method="post" action="/src/actions/cart.php" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $it['id']; ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn-remove-item" title="Remover item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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

<script>
function incrementQuantity(btn) {
    const input = btn.parentElement.querySelector('.quantity-input');
    input.value = parseInt(input.value) + 1;
    input.form.submit();
}

function decrementQuantity(btn) {
    const input = btn.parentElement.querySelector('.quantity-input');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.form.submit();
    }
}
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
