<?php
	session_start(); // Start current PHP session
	session_destroy(); // Destroy all data in the session
	header("Location: index.php"); // Redirect to login page
?>
