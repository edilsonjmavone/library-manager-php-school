<?php
require_once '../db_connection.php';
require_once '../config.php';

session_start();

$id = $_POST['id'] ?? '';
$title = $_POST['title'] ?? '';
$genre = $_POST['genre'] ?? '';
$author_id = $_POST['author_id'] ?? '';
$publication_date = $_POST['publication_date'] ?? '';

// Validate required fields
if (empty($title) || empty($genre) || empty($author_id) || empty($id) || empty($publication_date)) {
    showMessage("error", "Preencha todos os campos obrigatórios", "/views/livro/edit.php?id=$id");

}
// Prepare the UPDATE statement
$stmt = $db->prepare("UPDATE book SET title = ?, genre = ?, author_id = ?, publication_date = ? WHERE id = ?");
$stmt->bind_param("ssisi", $title, $genre, $author_id, $publication_date, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        // Success
        showMessage("success", "Livro atualizado com sucesso", );

    } else {
        // No rows changed (possibly same data)
        showMessage("erro", "Nenhuma alteração feita", );
    }
} else {
    // Error during update
    showMessage("error", "Erro ao atualizar livro", "/views/livro/edit.php?id=$id");
}

$stmt->close();
$db->close();
