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
            <a href="/src/pages/client/index.php" class="logo-container">
                <img src="/src/assets/images/logodelta.png" alt="Logo Delta"></a>
            <span class="header-text">O universo gamer começa aqui</span>

            <div class="header-icons">
                <a href="/src/pages/client/carrinho.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span>
                </a>
                <?php if(!empty($_SESSION['user_email'])): ?>
                    <a href="/src/actions/logout.php" style="margin-left:10px;">Sair</a>
                <?php else: ?>
                    <a href="/src/pages/client/login.php" style="margin-left:10px;">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
