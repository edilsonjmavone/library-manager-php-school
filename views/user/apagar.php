<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    redirect("/views/dashboard.php");
}

$id = $_GET['id'] ?? null;

if (!$id) {
    showMessage('error', 'ID do utilizador não fornecido.', '/views/user/listar.php');
}

// Verificar se o utilizador tem empréstimos ativos
$checkStmt = $db->prepare("SELECT COUNT(*) FROM borrowed_book WHERE user_id = ? AND return_date IS NULL");
$checkStmt->bind_param("i", $id);
$checkStmt->execute();
$checkStmt->bind_result($borrowCount);
$checkStmt->fetch();
$checkStmt->close();

if ($borrowCount > 0) {
    showMessage('error', 'Não é possível remover este utilizador porque possui empréstimos ativos.', '/views/user/listar.php');
    exit;
}

// Se não tem empréstimos ativos, apaga o histórico de empréstimos
$deleteBorrowed = $db->prepare("DELETE FROM borrowed_book WHERE user_id = ?");
$deleteBorrowed->bind_param("i", $id);
$deleteBorrowed->execute();
$deleteBorrowed->close();

// Agora pode apagar o utilizador
$stmt = $db->prepare("DELETE FROM user WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    showMessage('success', 'Utilizador removido com sucesso.', '/views/user/listar.php');
} else {
    showMessage('error', 'Erro ao remover utilizador.', '/views/user/listar.php');
}
?>
