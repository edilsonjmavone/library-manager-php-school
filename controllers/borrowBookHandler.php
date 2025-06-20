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

$stmt = $db->prepare("INSERT INTO borrowed_book (user_id, book_id, borrow_date) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $userID, $bookID, $dateNow);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    showMessage("success", "Livro requisitado com sucesso", "/views/livro/listar.php");
} else {
    showMessage("error", "Erro ao requisitar o livro", "/views/livro/listar.php");
}
