<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['user_role']) {
    redirect("/views/dashboard.php");
}

$id = $_SESSION['user_id'] ?? null;
if (!$id) {
    showMessage('error', 'ID do utilizador não fornecido.', '/views/user/listar.php');
}

$stmt = $db->prepare("SELECT user_name, role FROM user WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    showMessage('error', 'Utilizador não encontrado.', '/views/user/listar.php');
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['user_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $role = $_POST['role'] ?? 'user';

    $updateStmt = $db->prepare("UPDATE user SET user_name = ?, user_name = ?, role = ? WHERE id = ?");
    $updateStmt->bind_param("sssi", $name, $username, $role, $id);
    $updateStmt->execute();

    showMessage('success', 'Utilizador atualizado com sucesso.', '/views/user/listar.php');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Utilizador</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/formStyles.css">
    <style>
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
    <h1>Editar Utilizador</h1>
    <form method="post">
        <div class="form-group">
            <label for="user_name">Nome:</label>
            <input type="text" name="user_name" value="<?= htmlspecialchars($user['user_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['user_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Função:</label>
            <select name="role" <?= $user['role'] === 'admin' ? 'disabled' : '' ?> >
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilizador</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit">Atualizar</button>
            <a href="<?= BASE_URL ?>/views/user/listar.php" class="exitBtn">Cancelar</a>
        </div>
    </form>
</main>
</body>
</html>

