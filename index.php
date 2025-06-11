<?php
require 'config.php';

// echo dirname($_SERVER['SCRIPT_NAME']);
session_start();
if (!isset($_SESSION['user_id'])) {
    redirect("/views/login.php");
    exit();
}
redirect("/views/dashboard.php");
exit();