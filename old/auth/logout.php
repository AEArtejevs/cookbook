<?php
session_start();      // Start session if not already started
session_unset();      // Remove all session variables
session_destroy();    // Destroy the session

setcookie('name', '', time() - 3600, '/');
setcookie('last_visit', '', time() - 3600, '/');


header('Location: login.php');
exit();
?>
