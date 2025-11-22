<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
if (!isLogged() || empty($_SESSION['is_admin'])) {
    header('Location: /src/pages/client/login.php');
    exit;
}

$users = queryAll('SELECT id, email, is_admin FROM users ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - Admin</title>
    <link rel="stylesheet" href="/src/pages/admin/styles/admin-style.css">
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
                    <li><a href="/src/pages/admin/admin-produtos.php"><i class="fas fa-box-open"></i> Produtos</a></li>
                    <li><a href="/src/pages/admin/admin-categorias.php"><i class="fas fa-tags"></i> Categorias</a></li>
                    <li class="active"><a href="/src/pages/admin/admin-usuarios.php"><i class="fas fa-users"></i> Usuários</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="/src/actions/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h2>Usuários</h2>
            </header>
            <section class="content-table">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Email</th><th>Admin</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo !empty($u['is_admin']) ? 'Sim' : 'Não'; ?></td>
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
