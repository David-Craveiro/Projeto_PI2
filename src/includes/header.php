<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delta Store</title>
    <link rel="stylesheet" href="/src/pages/client/styles/style.css">
    <?php
    // Carrega o CSS do admin apenas quando a rota contém /src/pages/admin
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($requestUri, '/src/pages/admin') !== false) : ?>
        <link rel="stylesheet" href="/src/pages/admin/styles/admin-style.css">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="/src/pages/admin/admin-index.php" class="admin-btn" style="margin-right:15px; padding:5px 10px; background-color:transparent; color:white; border:2px solid #6D28D9; border-radius:4px; text-decoration:none; font-weight:500; font-size:12px; transition:all 0.3s;">Acesso Administrador</a>
            <div class="logo-section">
                <a href="/src/pages/client/index.php" class="logo-container">
                    <img src="/src/assets/images/logodelta.png" alt="Logo Delta">
                </a>
                <span class="header-text">O universo gamer começa aqui</span>
            </div>

            <div class="header-icons">
                <a href="/src/pages/client/carrinho.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span>
                </a>
                <?php if(!empty($_SESSION['user_email'])): ?>
                    <a href="/src/actions/logout.php" class="auth-btn" style="margin-left:10px; padding:8px 16px; background-color:#1F232E; color:white; border:2px solid #F97316; border-radius:5px; text-decoration:none; font-weight:600; font-size:15px; transition:all 0.3s;">Sair</a>
                <?php else: ?>
                    <a href="/src/pages/client/login.php" class="auth-btn" style="margin-left:10px; padding:8px 16px; background-color:#F97316; color:white; border-radius:5px; text-decoration:none; font-weight:600; font-size:15px; transition:all 0.3s;">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
