<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();

$bookId = $_GET['id'] ?? null;

if (empty($bookId)) {
    redirect("/views/dashboard.php?error=Livro não especificado");
    showMessage("erro", "Livro não especificado", "/views/livro/listar.php");
}

// Fetch book
$stmt = $db->prepare("SELECT * FROM book WHERE id = ?");
$stmt->bind_param("i", $bookId);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    showMessage("erro", "Livro não encontrado, na base de dados", "/views/livro/listar.php");
}

// Fetch authors
$authors = $db->query("SELECT id, name FROM author");

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Livro | Gestor de Biblioteca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles/global.css" />
    <link rel="stylesheet" href="../../styles/form.css" />
</head>

<body>
    <main>

        <form action="<?= BASE_URL ?>/controllers/editBookHandler.php" method="post">
            <div style="text-align: center; margin-bottom: 0.5rem;">
                <i class="fas fa-book" style="font-size: 2rem; color: #4db8ff;"></i>
            </div>

            <h1>Editar Livro</h1>

            <input type="hidden" name="id" value="<?= $book['id'] ?>">

            <label for="title">Titulo</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required />

            <label for="genre">Género</label>
            <input type="text" name="genre" id="genre" value="<?= htmlspecialchars($book['genre']) ?>" required>

            <label for="author_id">Autor</label>
            <select name="author_id" id="author_id">
                <option value="" disabled hidden>Selecione o Autor</option>
                <?php while ($row = $authors->fetch_assoc()):
                    $selected = $row['id'] == $book['author_id'] ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                endwhile; ?>
            </select>

            <label for="publication_date">Data de Publicação</label>
            <input type="date" name="publication_date" id="publication_date" value="<?= $book['publication_date'] ?>">

            <button type="submit">Guardar Alterações</button>

            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif; ?>
        </form>

        <div>
            <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">Cancelar</a>
        </div>

    </main>
</body>

</html>