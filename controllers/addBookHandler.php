<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$title = $_POST['title'] ?? '';
$genre = $_POST['genre'] ?? '';
$author_id = $_POST['author_id'] ?? '';
$publication_date = $_POST['publication_date'] ?? '';


if (empty($title) || empty($genre) || empty($author_id)) {
    redirect("/views/livro/registar.php?error=Preencha todos os campos");
}


$stmt = $db->prepare("INSERT into book (title, genre, author_id, publication_date) values(?,?,?,?)");
$stmt->bind_param("ssss", $title, $genre, $author_id, $publication_date);
$stmt->execute();
$result = $stmt->get_result();

if ($stmt->affected_rows > 0) {

    $bookId = $db->insert_id;

    // 3. Fetch the inserted row
    $result = $db->query("SELECT * FROM book WHERE id = $bookId");
    $book = $result->fetch_assoc();

    showMessage("success", "Livro '" . $book['title'] . "'Submetido com successo");

} else {
    redirect("/views/livro/registar.php?error=Erro ao registrar livro");
}


// controllers\adduserHandler.php
// C:\xampp\htdocs\phpmodule\library-manager-php\controllers\adduserHandler.php