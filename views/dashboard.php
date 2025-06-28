<?php
require '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect("/views/login.php");
}
$isAdmin = $_SESSION['user_role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel Principal</title>
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
</head>

<body>
    <main class="dashboard">
        <section class="dashboard-header">
            <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilizador') ?>!</h1>
            <p>Gerencie livros, autores e utilizadores a partir deste painel.</p>
        </section>

        <section popover id="book" class="pop-card">
            <div class="pop-card-content">
                <h2 class="title">Livros</h2>
                <a href="livro/registar.php">Adicionar Livro</a>
                <a href="<?= BASE_URL ?>/views/livro/listar.php">Listar Livros</a>
                <button popovertarget="book" popovertargetaction="hide" class="exitBtn">Sair</button>
            </div>
        </section>

        <section popover id="author" class="pop-card">
            <div class="pop-card-content">
                <h2 class="title">Autores</h2>
                <a href="<?= url("/views/autor/registar.php") ?>">Adicionar Autor</a>
                <a href="<?= url("/views/autor/listar.php") ?>">Listar Autores</a>
                <button popovertarget="author" popovertargetaction="hide" class="exitBtn">Sair</button>
            </div>
        </section>

        <section popover id="user" class="pop-card">
            <div class="pop-card-content">
                <h2 class="title">Utilizadores</h2>
                <a href="user/adicionar.php">Adicionar Utilizadores</a>
                <a href="<?= url("/views/user/listar.php") ?>">Listar Utilizadores</a>
                <button popovertarget="user" popovertargetaction="hide" class="exitBtn">Sair</button>
            </div>
        </section>


        <section class=" card-grid">
            <button popovertarget="book" class="card">📚 Livros</button>
            <button popovertarget="author" class="card">✍️ Autores</button>
            <button popovertarget="user" class="card">👥 Utilizadores</button>
            <button popovertarget="borrow" class="card">📖 Empréstimos</button>
        </section>

        <div class="logout">
            <a href="../controllers/logoutHandler.php">⏏️ Terminar sessão</a>
        </div>
    </main>
</body>

</html>