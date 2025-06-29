<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$bookID = $_GET['bookID'] ?? '';
$userID = $_SESSION['user_id'] ?? null;

if (empty($bookID) || empty($userID)) {
    redirect("/views/livro/listar.php");
}

$dateNow = date('Y-m-d');

$stmt = $db->prepare("UPDATE borrowed_book SET return_date = ? WHERE user_id = ? AND book_id = ? AND return_date IS NULL");
$stmt->bind_param("sii", $dateNow, $userID, $bookID);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    showMessage("success", "Livro devolvido com sucesso", "/views/livro/listarEmprestados.php");
} else {
    showMessage("error", "Erro ao devolver o livro", "/views/livro/listarEmprestados.php");
}
