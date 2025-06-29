<?php
require_once "config.php";

// Cria a conexão com mysqli corretamente
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verifica se a conexão falhou
if ($db->connect_error) {
    echo "<script>
        console.error('Failed to connect to database: " . $db->connect_error . "');
    </script>";
    exit();
} else {
    echo "<script>
        console.info('Connected to database: " . $db->host_info . "');
    </script>";
}
?>
