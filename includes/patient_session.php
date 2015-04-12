<?php
	
	require_once('database_connection.php');
	require_once("functions.php");
	session_start();
	
	if(!(isset($_SESSION['patient_login']) && $_SESSION['patient_login'] != '')){
		//Close Connection
		$closed = mysqli_close($connection);
		redirect("patient_signin.php");
	}
?>
