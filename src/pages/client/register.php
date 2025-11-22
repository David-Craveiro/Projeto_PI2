<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    try {
        $pdo->prepare('INSERT INTO users (email,password) VALUES (?,?)')->execute([$email,$password]);
        header('Location: /src/pages/client/login.php');
        exit;
    } catch (Exception $e) {
        $error = 'Erro ao cadastrar: ' . $e->getMessage();
    }
}
?>
<main class="container">
    <h2>Cadastro</h2>
    <?php if(!empty($error)) echo '<p style="color:red;">'.htmlspecialchars($error).'</p>'; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
