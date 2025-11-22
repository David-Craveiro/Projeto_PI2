<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
if (!isLogged() || empty($_SESSION['is_admin'])) {
    header('Location: /src/pages/client/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Delta Store</title>
    <link rel="stylesheet" href="/src/pages/admin/styles/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <li class="active"><a href="/src/pages/admin/admin-index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="/src/pages/admin/admin-produtos.php"><i class="fas fa-box-open"></i> Produtos</a></li>
                    <li><a href="/src/pages/admin/admin-categorias.php"><i class="fas fa-tags"></i> Categorias</a></li>
                    <li><a href="/src/pages/admin/admin-usuarios.php"><i class="fas fa-users"></i> Usuários</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="/src/actions/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <header>
                <h1>Seja Bem Vindo(a), Aqui Estão Algumas Instruções para melhor navegação.</h1>
            </header>
            <section class="instructions-grid">
                <div class="instruction-card">
                    <img src="/src/assets/images/cadastrar-produto.png" alt="Criar Produtos">
                    <h3>CRIAR PRODUTOS</h3>
                    <p>Crie, edite e exclua produtos com apenas alguns cliques.</p>
                </div>
                <div class="instruction-card">
                     <img src="/src/assets/images/cadastrar-categoria.png" alt="Criar Categoria">
                    <h3>CRIAR CATEGORIA</h3>
                    <p>Crie, edite e exclua categorias de forma simples e rápida.</p>
                </div>
                <div class="instruction-card">
                     <img src="/src/assets/images/cadastrar-usuario.png" alt="Gerenciar Usuários">
                    <h3>GERENCIAR USUÁRIOS</h3>
                    <p>Crie, edite e exclua usuários de forma simples e rápida.</p>
                </div>
            </section>
        </main>
    </div>
    <script src="/src/pages/admin/scripts/admin.js"></script>
</body>
</html>
