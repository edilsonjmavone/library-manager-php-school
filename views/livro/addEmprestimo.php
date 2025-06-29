<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//     redirect("/views/dashboard.php");
// }
if (!isset($_SESSION['user_id']) || 
   ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'user')) {
    redirect("/views/dashboard.php");
}

// Buscar livros disponíveis
$booksResult = $db->query("
    SELECT b.id, b.title 
    FROM book b 
    WHERE NOT EXISTS (
        SELECT 1 FROM borrowed_book bb 
        WHERE bb.book_id = b.id AND bb.return_date IS NULL
    )
");

// Buscar usuários
$usersResult = $db->query("SELECT id, user_name FROM user ORDER BY user_name ASC");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registrar Empréstimo</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/formStyles.css">
<style>
 main {
    max-width: 600px;
    margin: 40px auto;
    background-color: #1a1a1a;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(255, 101, 0, 0.2);
    color: #fff;
    font-family: 'Segoe UI', sans-serif;
}

h1 {
    text-align: center;
    margin-bottom: 24px;
    font-size: 28px;
    color: #ff6500;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    color: #ccc;
}

input[type="date"],
select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #333;
    border-radius: 6px;
    background-color: #2a2a2a;
    color: #f0f0f0;
}

input[type="date"]:focus,
select:focus {
    outline: none;
    border-color: #ff6500;
}

input[type="text"].styled-input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #333;
    border-radius: 6px;
    background-color: #2a2a2a;
    color: #f0f0f0;
}


.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
}

button[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #28a745;
    border: none;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

button[type="submit"]:hover {
    background-color: #218838;
}

.exitBtn {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
}

.exitBtn:hover {
    background-color: #c82333;
}


</style>

</head>

<body>
<main>
    <h1>Registar Empréstimo</h1>

    <form method="post" action="<?= BASE_URL ?>/controllers/aquisicao.php">
        <div class="form-group">
            <label for="book_id">Livro:</label>
            <select name="book_id" id="book_id" required>
                <option value="">Selecione um livro</option>
                <?php while ($book = $booksResult->fetch_assoc()): ?>
                    <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
                    <div class="form-group">
    <label>Usuário:</label>
    <input type="text" class="styled-input" value="<?= htmlspecialchars($_SESSION['user_name']) ?>" disabled>
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
</div>


        <div class="form-group">
            <label for="due_date">Data de Devolução:</label>
            <input type="date" name="due_date" id="due_date" required>
        </div>

        <div class="form-actions">
            <button type="submit">Guardar</button>
            <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">Cancelar</a>
        </div>
    </form>
</main>
</body>
</html>