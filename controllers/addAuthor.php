<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$name = $_POST['name'] ?? '';



if (empty($title) || empty($genre) || empty($author_id)) {
    redirect("/views/registarLivro.php?error=Preencha todos os campos");
}

$stmt = $db->prepare("INSERT into Author (name) values(?)");
$stmt->bind_param("s", $$name);
$stmt->execute();
$result = $stmt->get_result();

if ($stmt->affected_rows > 0) {

    $bookId = $db->insert_id;

    // 3. Fetch the inserted row
    $result = $db->query("SELECT * FROM book WHERE id = $bookId");
    $user = $result->fetch_assoc();

  
    redirect("/views/dashboard.php");

} else {
    redirect("/views/registarLivro.php?error=Erro ao registrar usuário");
}


// controllers\adduserHandler.php
// C:\xampp\htdocs\phpmodule\library-manager-php\controllers\adduserHandler.php