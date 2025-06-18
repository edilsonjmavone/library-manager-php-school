<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$bookID = $_GET['bookID'] ?? '';
$userID = $_SESSION['user_id'] ?? null;

if (empty($bookID) || empty($useID)) {
    redirect("/views/livro/listar.php");
}
$dateNow = date('Y-m-d');

$stmt = $db->prepare("UPDATE borrowed_book set return_date=? where user_id= ? AND book_id=? AND return_date IS NULL");
$stmt->bind_param("si", $dateNow, $userID, $bookID);
;
$stmt->execute();

if ($stmt->affected_rows > 0) {
    showMessage("success", "Livro requisitado com sucesso", "/views/livro/listar.php");
} else {
    showMessage("error", "Erro ao requisitar o livro", "/views/livro/listar.php");
}
