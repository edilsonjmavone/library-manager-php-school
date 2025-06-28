<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();
$isAdmin = $_SESSION['user_role'] === 'admin';

$query = "SELECT id, name FROM author ORDER BY name ASC";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Autores | Biblioteca</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/listStyles.css">
    <style>
        .book-actions a {
            display: inline-block;
            margin: 0.2rem;
            padding: 0.4rem 0.8rem;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: bold;
            transition: background-color 0.2s ease;
            color: #fff;
        }

        .edit {
            background-color: #007bff;
        }

        .delete {
            background-color: #dc3545;
        }

        .edit:hover {
            background-color: #0056b3;
        }

        .delete:hover {
            background-color: #a71d2a;
        }
    </style>
</head>

<body>
    <main>
        <h1>Lista de Autores</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome do Autor</th>
                        <?php if ($isAdmin): ?>
                            <th>Ações</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <?php if ($isAdmin): ?>
                                <td class="book-actions">
                                    <a href="editar.php?id=<?= $row['id'] ?>" class="edit">✏️ Editar</a>
                                    
                                    <a href="<?= url("/controllers/deleteAuthorHandler.php") ."?id=". $row['id'] ?>" class="delete" onclick="return confirm('Tem certeza que deseja remover este autor?')">🗑️ Remover</a>
                                    <a href="<?= BASE_URL ?>/views/livro/porAutor.php?autor_id=<?= $row['id'] ?>" class="view">📚 Ver Livros</a>

                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Sem autores registados.</p>
        <?php endif; ?>

        <div>
            <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">← Voltar ao dashboard</a>
        </div>
    </main>
</body>

</html>
