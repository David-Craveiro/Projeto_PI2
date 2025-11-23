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
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?>
                                <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $u['id']): ?>
                                    <small> (você)</small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo !empty($u['is_admin']) ? 'Sim' : 'Não'; ?></td>
                            <td>
                                <div class="actions-cell">
                                    <form action="/src/actions/admin_toggle_admin.php" method="post" style="display:inline-block; margin-right:6px;">
                                        <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                        <?php $disable_toggle = (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $u['id']); ?>
                                        <button type="submit" <?php echo $disable_toggle ? 'disabled' : ''; ?>>
                                            <?php echo !empty($u['is_admin']) ? 'Remover Admin' : 'Tornar Admin'; ?>
                                        </button>
                                    </form>

                                    <form action="/src/actions/admin_delete_user.php" method="post" style="display:inline-block;" onsubmit="return confirm('Confirma exclusão do usuário <?php echo htmlspecialchars($u['email']); ?>?');">
                                        <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                        <?php $disable_delete = (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $u['id']); ?>
                                        <button type="submit" <?php echo $disable_delete ? 'disabled' : ''; ?>>Deletar</button>
                                    </form>
                                </div>
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
