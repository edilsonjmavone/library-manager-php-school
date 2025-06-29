<?php
require_once '../../config.php';
require_once '../../db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('/views/login.php');
}

$userId = $_SESSION['user_id'];


$stmt = $db->prepare("SELECT id, email, user_name, role FROM user WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();


$query = "
SELECT b.id, b.title, bb.borrow_date, bb.return_date, bb.state 
FROM borrowed_book bb
JOIN book b ON bb.book_id = b.id
WHERE bb.user_id = ?
";
$stmtBooks = $db->prepare($query);
$stmtBooks->bind_param("i", $userId);
$stmtBooks->execute();
$booksResult = $stmtBooks->get_result();
?>

<!DOCTYPE html>
<html lang="pt">    

<head>
    <meta charset="UTF-8" />
    <title>Perfil de <?= htmlspecialchars($user['user_name']) ?></title>
    <link rel="stylesheet" href="<?= url('/styles/global.css') ?>" />
    <style>
        .profile-actions {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
        }

        .profile-actions .btn {
            background-color: #4fc3f7;
            color: #1e1e1e;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .profile-actions .btn:hover {
            background-color: #29b6f6;
        }

        .profile-actions .exitBtn {
            background-color: #ef5350;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .profile-actions .exitBtn:hover {
            background-color: #c82333;
        }

        .status-borrowed {
            color: #ffd54f;
            font-weight: bold;
        }

        .status-late {
            color: #ef5350;
            font-weight: bold;
        }

        .status-returned {
            color: #81c784;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            color: #eee;
        }

        th,
        td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #2a2a2a;
        }

        th {
            background-color: #2e2e2e;
            color: #ffb74d;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php include_once __DIR__ . '/../../components/navDock.php'; ?>

    <main>
        <h1>👤 Perfil de <?= htmlspecialchars($user['user_name']) ?></h1>

        <section>
            <h2>Informações Pessoais</h2>
            <ul>
                <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                <li><strong>Nome de Utilizador:</strong> <?= htmlspecialchars($user['user_name']) ?></li>
                <li><strong>Função:</strong> <?= $user['role'] === 'admin' ? 'Administrador' : 'Utilizador' ?></li>
            </ul>

            <div class="profile-actions">
                <a href="<?= url('/views/user/editar.php') ?>" class="btn">✏️ Editar Perfil</a>
                <a href="<?= url('/controllers/logoutHandler.php') ?>" class="exitBtn">⏏️ Terminar Sessão</a>
            </div>
        </section>

        <section>
            <h2>📚 Livros Emprestados</h2>
            <?php if ($booksResult->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = $booksResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['borrow_date']) ?></td>
                                <td><?= $book['return_date'] ? htmlspecialchars($book['return_date']) : '—' ?></td>
                                <td>
                                    <?php
                                    if ($book['state'] === 'borrowed') {
                                        echo '<span class="status-borrowed">Emprestado</span>';
                                    } elseif ($book['state'] === 'late') {
                                        echo '<span class="status-late">Em Atraso</span>';
                                    } elseif ($book['state'] === 'available' && $book['return_date']) {
                                        echo '<span class="status-returned">Devolvido</span>';
                                    } else {
                                        echo htmlspecialchars($book['state']);
                                    }


                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Não tem livros emprestados no momento.</p>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>