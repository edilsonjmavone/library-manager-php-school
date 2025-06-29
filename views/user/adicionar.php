<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    redirect("/views/dashboard.php");
}
// Processar envio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['user_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    // Validações
    if (!$name || !$username || !$email || !$password || !$confirm) {
        showMessage('error', 'Todos os campos são obrigatórios.');
    }

    if ($password !== $confirm) {
        showMessage('error', 'As senhas não coincidem.');
    }

    // Verifica se o email já existe
    $check = $db->prepare("SELECT id FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        showMessage('error', 'Este email já está em uso.');
    }

    // Inserir novo utilizador
    $pwdHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO user (user_name,  email, pwdHash, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name,  $email, $pwdHash, $role);
    $stmt->execute();

    showMessage('success', 'Utilizador registado e autenticado com sucesso.', '/views/dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Utilizador</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
main {
    max-width: 480px;
    margin: 30px auto;
    background-color: #1e1e1e;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(255, 101, 0, 0.2);
    color: #e0e0e0;
    font-family: 'Segoe UI', sans-serif;
}

h1 {
    text-align: center;
    margin-bottom: 1.2rem;
    font-size: 22px;
    color: #ff6500;
    text-shadow: 0 0 2px rgba(255, 101, 0, 0.5);
}

.form-group {
    margin-bottom: 1rem;
}

label {
    display: block;
    margin-bottom: 0.3rem;
    font-weight: 500;
    color: #ccc;
    font-size: 0.85rem;
}

label i {
    margin-right: 4px;
    color: #ff9800;
}

input,
select {
    width: 100%;
    padding: 0.6rem;
    font-size: 0.9rem;
    border: 1px solid #333;
    border-radius: 5px;
    background-color: #2a2a2a;
    color: #f0f0f0;
}

input:focus,
select:focus {
    outline: none;
    border-color: #ff6500;
    background-color: #2f2f2f;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 1.5rem;
    gap: 0.5rem;
}

button[type="submit"],
.exitBtn {
    flex: 1;
    padding: 0.55rem;
    font-size: 0.9rem;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
}

button[type="submit"] {
    background-color: #28a745;
    color: #fff;
    border: none;
}

button[type="submit"]:hover {
    background-color: #218838;
    transform: scale(1.01);
}

.exitBtn {
    background-color: #dc3545;
    color: white;
    border: none;
    text-decoration: none;
}

.exitBtn:hover {
    background-color: #c82333;
    transform: scale(1.01);
}

@media (max-width: 480px) {
    main {
        padding: 1rem;
        max-width: 90%;
    }

    h1 {
        font-size: 18px;
    }

    button,
    .exitBtn {
        font-size: 0.85rem;
        padding: 0.5rem;
    }
}

</style>

</head>
<body>
<main>
    <h1><i class="fas fa-user-plus"></i> Adicionar Utilizador</h1>

    <form method="post">
        <div class="form-group">
            <label for="user_name"><i class="fas fa-id-card"></i> Nome completo:</label>
            <input type="text" name="user_name" id="user_name" required>
        </div>

        <div class="form-group">
            <label for="username"><i class="fas fa-user"></i> Nome de utilizador:</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> E-mail:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Palavra-passe:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password"><i class="fas fa-check-circle"></i> Confirmar Palavra-passe:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>

        <div class="form-group">
            <label for="role"><i class="fas fa-user-tag"></i> Função:</label>
            <select name="role" id="role" required>
                <option value="user">Utilizador</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit"><i class="fas fa-save"></i> Guardar</button>
            <a href="<?= BASE_URL ?>/views/user/listar.php" class="exitBtn">Cancelar</a>
        </div>
    </form>
</main>
</body>
</html>
