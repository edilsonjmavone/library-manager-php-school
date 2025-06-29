<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    redirect("/views/dashboard.php");
}

$query = "SELECT id, user_name, role FROM user ORDER BY user_name ASC";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista de Utilizadores</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/listStyles.css">
</head>
<body>
<main>
    <h1>Lista de Utilizadores</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Username</th>
                    <th>Função</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_name']) ?></td>
                        <td><?= htmlspecialchars($user['user_name']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td class="book-actions">
                            <a href="editar.php?id=<?= $user['id'] ?>" class="edit">Editar</a>
                            <a href="apagar.php?id=<?= $user['id'] ?>" class="delete"
                               onclick="return confirm('Tem certeza que deseja eliminar este utilizador?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há utilizadores registados.</p>
    <?php endif; ?>

    <div>
        <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">← Voltar ao dashboard</a>
    </div>
</main>
</body>
</html>
