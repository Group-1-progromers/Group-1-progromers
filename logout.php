<?php
session_start();

// Destroy the session and all session data
session_unset();
session_destroy();

// Redirect to the homepage or login page
header("Location: index.php");
exit();
?>
