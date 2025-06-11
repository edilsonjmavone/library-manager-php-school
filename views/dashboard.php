<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect("/views/login.php");
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel Principal</title>
    <link rel="stylesheet" href="../styles/global.css" />
    <style>
        .dashboard {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            max-width: 800px;
            width: 100%;
        }

        .dashboard-header {
            text-align: center;
        }

        .dashboard-header h1 {
            color: #ffb74d;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: #bbb;
            font-size: 1rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .card {
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 6px;
            padding: 1.2rem;
            text-align: center;
            transition: background-color 0.2s ease;
        }

        .card:hover {
            background-color: #333;
        }

        .card a {
            color: #ffb74d;
            text-decoration: none;
            font-weight: bold;
        }

        .logout {
            margin-top: 1rem;
            text-align: center;
        }

        .logout a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: bold;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <main class="dashboard">
        <section class="dashboard-header">
            <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilizador') ?>!</h1>
            <p>Gerencie livros, autores e utilizadores a partir deste painel.</p>
        </section>

        <section class="card-grid">
            <div class="card"><a href="/views/books.php">📚 Livros</a></div>
            <div class="card"><a href="/views/authors.php">✍️ Autores</a></div>
            <div class="card"><a href="/views/users.php">👥 Utilizadores</a></div>
            <div class="card"><a href="/views/borrowed.php">📖 Empréstimos</a></div>
        </section>

        <div class="logout">
            <a href="../controllers/logoutHandler.php">⏏️ Terminar sessão</a>
        </div>
    </main>
</body>

</html>