<?php
require_once "config.php";

$db = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME,
    DB_PORT
);

if ($db->connect_error) {
    // echo "connection failed: " . $mysqli->connect_error;
    echo "<script>
    console.error(`Failed to connect database in: $db->connect_error`)
    </script>";
    exit();
} else {
    echo "<script>
    console.info(`Connected to database in: $db->host_info`)
    </script>";
}

?>