<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/header.php';

?>
<main class="container">
    <div class="login-container">
        <img src="/src/assets/images/logodelta.png" alt="Logo Delta" class="login-logo">
        <h2 class="login-title">DELTA</h2>
        <form class="login-form" method="post" action="/src/actions/login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit" class="btn btn-accent">Entrar</button>
        </form>
        <p>Não tem conta? <a href="/src/pages/client/register.php">Cadastre-se</a></p>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
