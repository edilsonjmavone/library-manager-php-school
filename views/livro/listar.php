<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();
$isAdmin = $_SESSION['user_role'] === 'admin';


$query = "SELECT b.id, b.title, b.status, b.genre, b.publication_date, a.name AS author 
          FROM book b 
          LEFT JOIN author a ON b.author_id = a.id";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Livros | Biblioteca</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/listStyles.css">
</head>

<body>
    <main>
        <h1>Lista de Livros</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Género</th>
                        <th>Autor</th>
                        <th>Data de Publicação</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['genre']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= htmlspecialchars($row['publication_date']) ?></td>
                            <td><?= $row['status'] === 'available' ? 'Disponível' : 'Emprestado' ?></td>
                            <td class="book-actions">
                                <?php if ($isAdmin): ?>
                                    <a href="editar.php?id=<?= $row['id'] ?>" class="edit">Editar</a>
                                    <a href="apagar.php?id=<?= $row['id'] ?>" class="delete">Apagar</a>
                                <?php endif; ?>

                                <?php if ($row['status'] === 'available'): ?>
                                    <a href="borrowBookHandler.php?bookID=<?= $row['id'] ?>" class="borrow">Emprestar</a>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Sem livros registados.</p>
        <?php endif; ?>
    </main>
</body>

</html>