<?php
require_once '../../db_connection.php';
require_once '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    redirect("/views/dashboard.php");
}

$id = $_GET['id'] ?? null;

if (!$id) {
    showMessage('error', 'ID do utilizador não fornecido.', '/views/livro/listar.php');
}

$stmt = $db->prepare("DELETE FROM book WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    showMessage('success', 'Utilizador removido com sucesso.', '/views/livro/listar.php');
} else {
    showMessage('error', 'Erro ao remover utilizador.', '/views/livro/listar.php');
}
?>