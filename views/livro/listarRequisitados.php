<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();
$isAdmin = $_SESSION['user_role'] === 'admin';

$user_id = $_SESSION["user_id"];

$stmt = $db->prepare("SELECT 
    b.id, 
    b.title, 
    b.genre, 
    a.name AS author, 
    b.publication_date,
    b.status,
    b_b.borrow_date
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
LEFT JOIN borrowed_book b_b ON b.id = b_b.book_id
WHERE b_b.user_id = ?  
  AND b_b.return_date IS NULL");

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
    <main>
        <h1>Lista de Livros Requisitados</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Género</th>
                        <th>Autor</th>
                        <th>Data Aquisicao</th>
                        <th>Disponíveis</th>
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
                                    <a href="removerLivro.php?id=<?= $row['id'] ?>" class="delete">Apagar</a>
                                <?php endif; ?>

                                <?php if ($row['status'] === 'available'): ?>
                                    <a href="<?= BASE_URL ?>/controllers/borrowBookHandler.php?bookID=<?= $row['id'] ?>"
                                        class="borrow">Requisitar</a>
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
            <a href="<?= BASE_URL ?>/views/livro/listar.php" class="exitBtn">a</a>
        </div>
    </main>
</body>

</html>