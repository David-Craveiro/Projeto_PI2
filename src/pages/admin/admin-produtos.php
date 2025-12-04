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
                <div style="margin: 1rem 0 0 0; text-align: center;">
                    <a href="/src/pages/client/index.php" class="btn btn-accent" style="display:inline-block; padding:8px 16px; background:#007bff; color:#fff; border-radius:4px; text-decoration:none;">Ir para Home Cliente</a>
                </div>
            </nav>
            <div class="sidebar-footer">
                <a href="/src/actions/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h2>Produtos</h2>
            </header>
            
            <section class="form-section">
                <h3>Adicionar Novo Produto</h3>
                <form method="post" action="/src/actions/admin_add_product.php" class="add-product-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nome do Produto</label>
                            <input type="text" id="name" name="name" placeholder="Digite o nome do produto" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Preço</label>
                            <input type="number" id="price" step="0.01" name="price" placeholder="0.00" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="image">URL da Imagem</label>
                            <input type="text" id="image" name="image" placeholder="/src/assets/images/produto.png">
                        </div>
                        <div class="form-group">
                            <label for="stock">Estoque</label>
                            <input type="number" id="stock" name="stock" min="0" placeholder="0">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea id="description" name="description" placeholder="Digite a descrição do produto" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary">Adicionar Produto</button>
                </form>
            </section>
            <section class="content-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>IMAGEM</th>
                            <th>DESCRIÇÃO</th>
                            <th>ESTOQUE</th>
                            <th>PREÇO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"></td>
                            <td><?php echo nl2br(htmlspecialchars(mb_strimwidth($p['description'] ?? '', 0, 120, '...'))); ?></td>
                            <td><?php echo (int)($p['stock'] ?? 0); ?></td>
                            <td>R$ <?php echo number_format($p['price'],2,',','.'); ?></td>
                            <td class="actions">
                                <a class="edit" href="/src/pages/admin/edit_product.php?id=<?php echo $p['id']; ?>">editar</a>
                                <form method="post" action="/src/actions/admin_delete_product.php" onsubmit="return confirm('Deseja excluir este produto?');">
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
