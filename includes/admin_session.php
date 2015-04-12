<?php
	
	require_once('database_connection.php');													// to access admin's data in database
	require_once("functions.php");
	session_start();
	
	if(!(isset($_SESSION['admin_login']) && $_SESSION['admin_login'] != '')){
		//Close Connection
		$closed = mysqli_close($connection);
		redirect("admin_signin.php");
	}
?>
