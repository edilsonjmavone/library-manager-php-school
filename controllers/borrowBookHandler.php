<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$bookID = $_GET['bookID'] ?? '';
$useID = $_SESSION['user_id'];


if (empty($bookID)) {
    redirect("/views/dashboard.php");
}

$pwdHash = password_hash($password, PASSWORD_DEFAULT, );

$stmt = $db->prepare("INSERT into borrow_book (user_id, book_Id) values(?,?)");
$stmt->bind_param("ss", $email, $pwdHash);
$stmt->execute();
$result = $stmt->get_result();

if ($stmt->affected_rows > 0) {

    $userId = $db->insert_id;

    // 3. Fetch the inserted row
    $result = $db->query("SELECT * FROM user WHERE id = $userId");
    $user = $result->fetch_assoc();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];

    redirect("/views/dashboard.php");

} else {
    redirect("/views/registarUsuario.php?error=Erro ao registrar usuário");
}


// controllers\adduserHandler.php
// C:\xampp\htdocs\phpmodule\library-manager-php\controllers\adduserHandler.php