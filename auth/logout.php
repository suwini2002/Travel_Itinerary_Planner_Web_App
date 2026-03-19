<?php
require_once '../includes/functions.php';

// Destroy the session variables and the session itself
$_SESSION = [];
session_destroy();

// Redirect to home page
header("Location: ../index.php");
exit;
?>
