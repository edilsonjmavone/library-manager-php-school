<?php

$db = mysqli_connect(
    "localhost",
    "admin",
    "dev.js",
    "lib_manager",
    3307
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