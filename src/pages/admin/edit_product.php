<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
if (!isLogged() || empty($_SESSION['is_admin'])) {
    header('Location: /src/pages/client/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: /src/pages/admin/admin-produtos.php');
    exit;
}

$product = queryOne('SELECT * FROM products WHERE id = ?', [$id]);
if (!$product) {
    header('Location: /src/pages/admin/admin-produtos.php');
    exit;
}
require_once __DIR__ . '/../../includes/header.php';
?>
<main class="container">
    <h2>Editar produto</h2>
    <form method="post" action="/src/actions/admin_update_product.php">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <label>Nome:<br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </label><br>
        <label>Imagem (URL):<br>
            <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
        </label><br>
        <label>Preço:<br>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </label><br>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
        <a href="/src/pages/admin/admin-produtos.php" class="btn">Cancelar</a>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
