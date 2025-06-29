<?php
require_once '../db_connection.php';
require_once '../config.php';
session_start();

// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//     redirect("/views/dashboard.php");
// }

// $bookID = $_POST['book_id'] ?? '';
// $userID = $_POST['user_id'] ?? '';
// $dueDate = $_POST['due_date'] ?? '';

// if (empty($bookID) || empty($userID) || empty($dueDate)) {
//     showMessage("error", "Todos os campos são obrigatórios.", "/views/emprestimo/cadastrar.php");
// }
if (!isset($_SESSION['user_id']) || 
   ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'user')) {
    redirect("/views/dashboard.php");
}

$bookID = $_POST['book_id'] ?? '';
$userID = $_SESSION['user_id']; // ✅ usar sempre o id da sessão
$dueDate = $_POST['due_date'] ?? '';

if (empty($bookID) || empty($dueDate)) {
    showMessage("error", "Todos os campos são obrigatórios.", "/views/emprestimo/cadastrar.php");
}

// Verificar se o livro já está emprestado
$check = $db->prepare("SELECT 1 FROM borrowed_book WHERE book_id = ? AND return_date IS NULL");
$check->bind_param("i", $bookID);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    showMessage("error", "Este livro já está emprestado.", "/views/emprestimo/cadastrar.php");
}

$borrowDate = date('Y-m-d');

// $stmt = $db->prepare("
//     INSERT INTO borrowed_book (book_id, user_id, borrow_date, return_date) 
//     VALUES (?, ?, ?, ?)
// ");
// $stmt->bind_param("iiss", $bookID, $userID, $borrowDate, $dueDate);
$stmt = $db->prepare("
    INSERT INTO borrowed_book (book_id, user_id, borrow_date, due_date) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("iiss", $bookID, $userID, $borrowDate, $dueDate);


if ($stmt->execute()) {
    showMessage("success", "Empréstimo registado com sucesso.", "/views/livro/listarEmprestados.php");
} else {
    showMessage("error", "Erro ao registar empréstimo.", "/views/emprestimo/cadastrar.php");
}
