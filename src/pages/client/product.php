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
    <h2 class="section-title"><?php echo htmlspecialchars($product['name']); ?></h2>
    <div class="product-detail">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <div class="product-info">
            <p class="card-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
            <form method="post" action="/src/actions/cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label>Quantidade: <input type="number" name="quantity" value="1" min="1"></label>
                <button class="btn btn-primary" type="submit">Adicionar ao carrinho</button>
            </form>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
