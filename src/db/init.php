<?php
// Script de inicialização do banco (executar via CLI php)
$dbDir = __DIR__;
$dbFile = $dbDir . '/database.sqlite';
if (!file_exists($dbFile)) {
    touch($dbFile);
}

$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = file_get_contents(__DIR__ . '/migrations.sql');
$pdo->exec($sql);

// inserir alguns produtos se tabela vazia
$count = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
if ($count == 0) {
    $products = [
        ['Marvel\'s Spider-Man 2 PS5', 263.34, '/src/assets/images/SpiderMan2.png', 'Jogo de ação e aventura no PS5.'],
        ['EA Sports FC 25 PS5', 350.00, '/src/assets/images/FC25.png', 'Jogo de futebol com recursos atualizados.'],
        ['F1: 2025', 370.00, '/src/assets/images/f1.jpg', 'Simulador de corrida oficial da temporada 2025.']
    ];
    $stmt = $pdo->prepare('INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)');
    foreach ($products as $p) {
        $stmt->execute($p);
    }
}

// criar usuário admin se não existir
$adminEmail = 'admin@deltastore.local';
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
if ($stmt->execute([$adminEmail]) && $stmt->fetchColumn() == 0) {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare('INSERT INTO users (nome, telefone, email, password, is_admin) VALUES (?,?,?,?,1)')->execute([
        'Administrador',
        '(00) 00000-0000',
        $adminEmail,
        $hash
    ]);
}

echo "Banco inicializado em: $dbFile\n";
