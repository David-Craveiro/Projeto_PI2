<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if ($nome === '' || $telefone === '' || $email === '' || empty($_POST['password'])) {
        $error = 'Preencha todos os campos.';
    } else {
        try {
            $pdo->prepare('INSERT INTO users (nome, telefone, email, password) VALUES (?,?,?,?)')->execute([$nome, $telefone, $email, $password]);
            header('Location: /src/pages/client/login.php');
            exit;
        } catch (Exception $e) {
            $error = 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }
}
?>
<main class="container">
    <h2>Cadastro</h2>
    <?php if(!empty($error)) echo '<p style="color:red;">'.htmlspecialchars($error).'</p>'; ?>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="text" name="telefone" placeholder="Telefone" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
