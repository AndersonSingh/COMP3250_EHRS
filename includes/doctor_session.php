<?php
	
	require_once('database_connection.php');
	require_once("functions.php");
	session_start();
	
	if(!(isset($_SESSION['doctor_login']) && $_SESSION['doctor_login'] != '')){
		//Close Connection
		$closed = mysqli_close($connection);
		redirect("doctor_signin.php");
	}
?>
