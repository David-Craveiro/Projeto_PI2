<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = queryOne('SELECT * FROM products WHERE id = ?', [$id]);
if (!$product) {
    echo '<main class="container"><h2>Produto não encontrado</h2></main>';
    require_once __DIR__ . '/../../includes/footer.php';
    exit;
}
?>
<main class="container">
    <div class="product-detail-layout">
        <div class="product-image">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="divider"></div>
            <p class="price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
            
            <?php if (!empty($product['description'])): ?>
            <div class="product-description">
                <h3>Descrição</h3>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>
            <div class="divider"></div>
            <?php endif; ?>
            
            <form method="post" action="/src/actions/cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label>Quantidade: <input type="number" name="quantity" value="1" min="1"></label>
                <div class="action-buttons">
                    <button class="btn btn-primary" type="submit">Adicionar ao carrinho</button>
                    <a href="/src/pages/client/index.php" class="btn btn-secondary">Continuar Comprando</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
