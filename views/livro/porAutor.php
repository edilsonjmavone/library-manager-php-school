<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();

// Verifica se o ID do autor foi fornecido
if (!isset($_GET['autor_id'])) {
    showMessage('erro', 'ID do autor não fornecido.');
}

$autor_id = (int) $_GET['autor_id'];

// Buscar nome do autor
$stmtAutor = $db->prepare("SELECT name FROM author WHERE id = ?");
$stmtAutor->bind_param("i", $autor_id);
$stmtAutor->execute();
$resultAutor = $stmtAutor->get_result();

if ($resultAutor->num_rows === 0) {
    showMessage('erro', 'Autor não encontrado.');
}

$autor = $resultAutor->fetch_assoc();

// Buscar livros do autor
$stmtLivros = $db->prepare("
    SELECT 
        b.id,
        b.title,
        b.genre,
        b.publication_date,
        CASE 
            WHEN EXISTS (
                SELECT 1 FROM borrowed_book bb WHERE bb.book_id = b.id AND bb.return_date IS NULL
            ) THEN 'Emprestado'
            ELSE 'Disponível'
        END AS status
    FROM book b
    WHERE b.author_id = ?
    ORDER BY b.title ASC
");
$stmtLivros->bind_param("i", $autor_id);
$stmtLivros->execute();
$livros = $stmtLivros->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Livros de <?= htmlspecialchars($autor['name']) ?></title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/listStyles.css">
</head>
<body>
    <main>
        <h1>Livros de <?= htmlspecialchars($autor['name']) ?></h1>

        <?php if ($livros->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Género</th>
                        <th>Data de Publicação</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($livro = $livros->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($livro['title']) ?></td>
                            <td><?= htmlspecialchars($livro['genre']) ?></td>
                            <td><?= htmlspecialchars($livro['publication_date']) ?></td>
                            <td><?= $livro['status'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Este autor ainda não possui livros registados.</p>
        <?php endif; ?>

        <div>
            <a href="<?= BASE_URL ?>/views/autor/listarAutores.php" class="exitBtn">← Voltar para lista de autores</a>
        </div>
    </main>
</body>
</html>
