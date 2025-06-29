<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php';

$userName = htmlspecialchars($_SESSION['user_name'] ?? 'Utilizador');
?>

<div class="nav-dock">
    <div class="user-dropdown">
        <button class="user-button">👋 <?= $userName ?> ⌄</button>
        <div class="dropdown-content">
            <a href="<?= url('/views/user/profile.php') ?>">⚙️ Perfil</a>
            <a href="<?= url('/controllers/logoutHandler.php') ?>" class="logout">⏏️ Logout</a>
        </div>
    </div>

    <a href="<?= url('/views/dashboard.php') ?>">🏠 Dashboard</a>
    <a href="<?= url('/views/livro/listar.php') ?>">📚 Livros</a>
    <a href="<?= url('/views/autor/listar.php') ?>">✍️ Autores</a>
    <a href="<?= url('/views/user/listar.php') ?>">👥 Utilizadores</a>
</div>