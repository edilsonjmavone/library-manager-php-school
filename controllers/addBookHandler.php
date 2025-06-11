<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$title = $_POST['title'] ?? '';
$genre = $_POST['genre'] ?? '';
$author_id = $_POST['author_id'] ?? '';


if (empty($title) || empty($genre) || empty($author_id)) {
    redirect("/views/registarLivro.php?error=Preencha todos os campos");
}


$stmt = $db->prepare("INSERT into book (title, genre, author_id) values(?,?,?)");
$stmt->bind_param("sss", $title, $genre, $author_id);
$stmt->execute();
$result = $stmt->get_result();

if ($stmt->affected_rows > 0) {

    $bookId = $db->insert_id;

    // 3. Fetch the inserted row
    $result = $db->query("SELECT * FROM book WHERE id = $bookId");
    $user = $result->fetch_assoc();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];

    redirect("/views/dashboard.php");

} else {
    redirect("/views/registarLivro.php?error=Erro ao registrar usuário");
}


// controllers\adduserHandler.php
// C:\xampp\htdocs\phpmodule\library-manager-php\controllers\adduserHandler.php