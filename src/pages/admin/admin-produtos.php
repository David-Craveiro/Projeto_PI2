<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
if (!isLogged() || empty($_SESSION['is_admin'])) {
    header('Location: /src/pages/client/login.php');
    exit;
}

$products = queryAll('SELECT * FROM products ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Admin</title>
    <link rel="stylesheet" href="/src/pages/admin/styles/admin-style.css">
    <link rel="stylesheet" href="/src/pages/client/styles/style.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="/src/assets/images/logodelta.png" alt="Logo Delta" class="sidebar-logo">
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="/src/pages/admin/admin-index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="active"><a href="/src/pages/admin/admin-produtos.php"><i class="fas fa-box-open"></i> Produtos</a></li>
                    <li><a href="/src/pages/admin/admin-categorias.php"><i class="fas fa-tags"></i> Categorias</a></li>
                    <li><a href="/src/pages/admin/admin-usuarios.php"><i class="fas fa-users"></i> Usuários</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="/src/actions/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h2>Produtos</h2>
                <form method="post" action="/src/actions/admin_add_product.php" class="add-product-form">
                    <input type="text" name="name" placeholder="Nome do produto" required>
                    <input type="text" name="image" placeholder="URL da imagem (ex: /src/assets/images/img.png)">
                    <input type="number" step="0.01" name="price" placeholder="Preço" required>
                    <input type="text" name="description" placeholder="Descrição do produto (curta)">
                    <button type="submit" class="btn-primary">Adicionar produto</button>
                </form>
            </header>
            <section class="content-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>IMAGEM</th>
                            <th>PREÇO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($p['image']); ?>" alt="" style="max-width:80px;"></td>
                            <td>R$ <?php echo number_format($p['price'],2,',','.'); ?></td>
                            <td class="actions">
                                <a class="edit" href="/src/pages/admin/edit_product.php?id=<?php echo $p['id']; ?>">editar</a>
                                <form method="post" action="/src/actions/admin_delete_product.php" onsubmit="return confirm('Deseja excluir este produto?');" style="display:inline-block; margin-left:6px;">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <button class="delete" type="submit">excluir</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="/src/pages/admin/scripts/admin.js"></script>
</body>
</html>
