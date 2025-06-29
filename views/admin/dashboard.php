<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    redirect("/views/dashboard.php");
}

function countTable($db, $table, $where = '') {
    $query = "SELECT COUNT(*) AS total FROM $table" . ($where ? " WHERE $where" : "");
    $result = $db->query($query);
    return $result->fetch_assoc()['total'] ?? 0;
}

$totalLivros = countTable($db, 'book');
$totalAutores = countTable($db, 'author');
$totalUsuarios = countTable($db, 'user');
$emprestados = countTable($db, 'borrowed_book', 'return_date IS NULL');
$livrosDisponiveis = $totalLivros - $emprestados;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrativo</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/dashboard.css">
</head>
<body>
    <main>
        <h1>Dashboard Administrativo</h1>
        <div class="dashboard-grid">
            <div class="card">
                <h2><?= $totalLivros ?></h2>
                <p>Total de Livros</p>
            </div>
            <div class="card">
                <h2><?= $livrosDisponiveis ?></h2>
                <p>Livros Disponíveis</p>
            </div>
            <div class="card">
                <h2><?= $emprestados ?></h2>
                <p>Livros Emprestados</p>
            </div>
            <div class="card">
                <h2><?= $totalAutores ?></h2>
                <p>Autores</p>
            </div>
            <div class="card">
                <h2><?= $totalUsuarios ?></h2>
                <p>Utilizadores</p>
            </div>
        </div>
        <div style="text-align:center; margin-top: 30px;">
            <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">← Voltar</a>
        </div>
    </main>
</body>
</html>
