<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();

// Verifica se o utilizador é administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    showMessage('erro', 'Acesso não autorizado.');
}

// Verifica se o ID do autor foi passado
if (!isset($_GET['id'])) {
    showMessage('erro', 'ID do autor não fornecido.');
}

$author_id = (int) $_GET['id'];
$author = null;

// Buscar os dados atuais do autor
$stmt = $db->prepare("SELECT * FROM author WHERE id = ?");
$stmt->bind_param("i", $author_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    showMessage('erro', 'Autor não encontrado.');
} else {
    $author = $result->fetch_assoc();
}

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (empty($name)) {
        showMessage('erro', 'O nome do autor é obrigatório.');
    }

    $updateStmt = $db->prepare("UPDATE author SET name = ? WHERE id = ?");
    $updateStmt->bind_param("si", $name, $author_id);

    if ($updateStmt->execute()) {
        showMessage('success', 'Autor atualizado com sucesso.', '/views/autor/listarAutores.php');
    } else {
        showMessage('erro', 'Erro ao atualizar o autor.');
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Autor</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/formStyles.css">

    <style>
        /* formStyles.css */

main {
    max-width: 600px;
    margin: 3rem auto;
    background-color: #1e1e1e;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(255, 101, 0, 0.2);
    color: #fff;
}

h1 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 1.8rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
    width: 100%;
    padding: 0.75rem;
    border-radius: 8px;
    border: none;
    background-color: #2c2c2c;
    color: #fff;
    font-size: 1rem;
}

input:focus {
    outline: none;
    box-shadow: 0 0 5px #ff6500;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

button {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
    background-color: #28a745;
    border: none;
    border-radius: 6px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

button:hover {
    background-color: #218838;
}

.exitBtn {
    padding: 0.6rem 1.2rem;
    background-color: #dc3545;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.2s ease;
}

.exitBtn:hover {
    background-color: #c82333;
}

    </style>
</head>
<body>
    <main>
        <h1>Editar Autor</h1>
        <form method="post">
            <div class="form-group">
                <label for="name">Nome do Autor:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($author['name']) ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit">Salvar</button>
                <a href="<?= BASE_URL ?>/views/autor/listarAutores.php" class="exitBtn">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
