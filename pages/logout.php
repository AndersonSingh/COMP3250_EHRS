<?php
	require_once("../includes/functions.php");
	session_start();
	
// remove all session variables
	session_unset(); 

// destroy the session 
	session_destroy(); 
	
	redirect("login_home.php");
?>