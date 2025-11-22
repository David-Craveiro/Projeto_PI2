<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';

$products = queryAll('SELECT * FROM products');
?>
<main>
    <section class="hero-banner">
        <img src="/src/assets/images/FarCryBanner.png" alt="Banner Principal">
    </section>

    <section class="product-section container">
        <h2 class="section-title">OFERTAS</h2>
        <div class="product-grid">
            <?php foreach($products as $p): ?>
            <div class="product-card">
                <a href="/src/pages/client/product.php?id=<?php echo $p['id']; ?>"><img src="<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"></a>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h3>
                    <p class="card-price">R$ <?php echo number_format($p['price'], 2, ',', '.'); ?></p>
                    <form method="post" action="/src/actions/cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                        <button class="btn btn-primary" type="submit">Adicionar</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
