<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();

$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
$user_id = $_SESSION['user_id'] ?? null;

// Consulta para listar os livros emprestados
// Se for admin, mostra todos; se não, só mostra os emprestados ao próprio usuário
// $query = "
//     SELECT 
//         b.id AS book_id,
//         b.title,
//         u.id AS user_id,
//         u.user_name,
//         bb.borrow_date,
//         bb.return_date
//     FROM borrowed_book bb
//     JOIN book b ON bb.book_id = b.id
//     JOIN user u ON bb.user_id = u.id
//     WHERE bb.return_date IS NULL
// ";
$query = "
    SELECT 
        b.id AS book_id,
        b.title,
        u.id AS user_id,
        u.user_name,
        bb.borrow_date,
        bb.due_date,
        bb.return_date
    FROM borrowed_book bb
    JOIN book b ON bb.book_id = b.id
    JOIN user u ON bb.user_id = u.id
    WHERE bb.return_date IS NULL
";


if (!$isAdmin) {
    $query .= " AND u.id = ?";
}

$stmt = $db->prepare($query);

if (!$isAdmin) {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Livros Emprestados</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/listStyles.css">
</head>
<body>
<main>
    <h1>Livros Emprestados</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Usuário</th>
                    <th>Data Empréstimo</th>
                    <th>Data Devolução</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php 
                    $dueDate = $row['due_date'];
                    $now = new DateTime();
                    $due = new DateTime($dueDate);
                    $isLate = $now > $due;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['borrow_date']))) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($dueDate))) ?></td>
                        <td style="color: <?= $isLate ? 'red' : 'green' ?>;">
                            <?= $isLate ? 'Atrasado' : 'No prazo' ?>
                        </td>
                        <td>
                            <?php if ($isAdmin || $row['user_id'] == $user_id): ?>
                                <a href="<?= BASE_URL ?>/controllers/devolucao.php?bookID=<?= $row['book_id'] ?>" 
                                   onclick="return confirm('Confirmar devolução do livro?')"
                                   class="return">Devolver</a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há livros emprestados no momento.</p>
    <?php endif; ?>

    <div>
        <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">← Voltar ao dashboard</a>
    </div>
</main>
</body>
</html>
