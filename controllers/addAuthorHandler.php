<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$name = $_POST['name'] ?? '';


if (empty($name)) {
    redirect("/views/autor/registar.php?error=Preencha todos os campos");
}

$stmt = $db->prepare("INSERT into author (name) values(?)");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($stmt->affected_rows > 0) {

    showMessage("success", "Autor registado com successo");

} else {
    // showMessage("success", "Autor Submetido com successo");
    redirect("/views/autor/registar.php?error=Erro ao registar Autor");
}


// controllers\adduserHandler.php
// C:\xampp\htdocs\phpmodule\library-manager-php\controllers\adduserHandler.php