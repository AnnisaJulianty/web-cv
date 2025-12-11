<?php
session_start();

// Debugging: Check session status
echo "Debug: admin_logged_in is " . (isset($_SESSION['admin_logged_in']) ? ($_SESSION['admin_logged_in'] ? 'true' : 'false') : 'not set') . "<br>";
// exit; // Uncomment this line to stop execution here and see the debug output

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location: index.php");
    exit;
}
?>