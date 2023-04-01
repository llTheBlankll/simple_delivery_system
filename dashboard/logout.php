<?php
session_start();

if (session_status() === PHP_SESSION_ACTIVE) {
    unset($_SESSION["user_id"]);
    unset($_SESSION["username"]);
    session_destroy();
}

header("Location: /index.php");
?>