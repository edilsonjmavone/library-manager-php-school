<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();

// Verificar se é admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    showMessage('erro', 'Acesso negado. Apenas administradores podem remover autores.');
}

// Verificar se ID foi fornecido
if (!isset($_GET['id'])) {
    showMessage('erro', 'ID do autor não fornecido.');
}

$author_id = (int) $_GET['id'];

// Verifica se o autor existe
$stmt = $db->prepare("SELECT * FROM author WHERE id = ?");
$stmt->bind_param("i", $author_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    showMessage('erro', 'Autor não encontrado.');
}

// Tenta apagar
$deleteStmt = $db->prepare("DELETE FROM author WHERE id = ?");
$deleteStmt->bind_param("i", $author_id);

if ($deleteStmt->execute()) {
    showMessage('success', 'Autor removido com sucesso.', '/views/autor/listarAutores.php');
} else {
    showMessage('erro', 'Erro ao remover autor. Verifique se ele está associado a livros.');
}
