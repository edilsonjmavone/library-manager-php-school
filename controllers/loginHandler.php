<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$_COOKIE["theme"] = "white";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    redirect("/views/login.php?error=Preencha todos os campos");
}

$stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect("/views/login.php?error=Credenciais inválidas");
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['pwdHash'])) {
    redirect("/views/login.php?error=Credenciais inválidas");
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['user_name'] = $user['user_name'];





redirect("/views/dashboard.php");
