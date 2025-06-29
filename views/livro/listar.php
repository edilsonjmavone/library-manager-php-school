<?php

use Soap\Url;

require_once '../../db_connection.php';
require_once '../../config.php';

session_start();
$isAdmin = $_SESSION['user_role'] === 'admin';
$user_id = $_SESSION['user_id'];

$query = "
SELECT 
    b.id, 
    b.title, 
    b.genre, 
    b.publication_date, 
    a.name AS author,
    CASE 
        WHEN EXISTS (
            SELECT 1 FROM borrowed_book bb WHERE bb.book_id = b.id AND bb.return_date IS NULL
        ) THEN 'borrowed_by_someone'
        ELSE 'available'
    END AS availability,
    CASE 
        WHEN EXISTS (
            SELECT 1 FROM borrowed_book bb WHERE bb.book_id = b.id AND bb.user_id = ? AND bb.return_date IS NULL
        ) THEN 'borrowed_by_user'
        ELSE 'not_borrowed_by_user'
    END AS user_borrow_status
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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

<?php include_once __DIR__ . '/../../components/navDock.php'; ?>

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
                            <td class="book-actions">
                                <?php if ($isAdmin): ?>
                                    <a href="editar.php?id=<?= $row['id'] ?>" class="edit">Editar</a>
                                    <a href="<?= url("/controllers/deleteBook.php")?>?id=<?= $row['id'] ?>" class="delete">Apagar</a>
                                <?php endif; ?>

                                <?php if ($row['availability'] === 'available'): ?>
                                    <a href="<?= url("/controllers/borrowBookHandler.php") ?>?bookID=<?= $row['id'] ?>"
                                        class="borrow">Requisitar</a>

                                <?php elseif ($row['user_borrow_status'] === 'borrowed_by_user'): ?>
                                    <a href="<?= url("/controllers/returnBookHandler.php") ?>?bookID=<?= $row['id'] ?>"
                                        class="return">Devolver</a>

                                <?php else: ?>
                                    <span>Emprestado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Sem livros registados.</p>
        <?php endif; ?>
         <div>
            <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">Regressar ao dashboard</a>
        </div>
         <div>
            <a href="<?= BASE_URL ?>/views/livro/listarRequisitados.php" class="exitBtn">a</a>
        </div>
    </main>
</body>

</html>