<?php
	require_once("../includes/database_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validations.php");
	
	session_start();
	
	if(isset($_POST["submit"])){

		$user = $_POST["user_name"];
		$pass = $_POST["password"];
		$pass2 = $_POST["confirm_password"];
		$fName = $_POST["first_name"];
		$lName = $_POST["last_name"];
		
		// check if passwords match
		if(strcmp($pass,$pass2) != 0){
			$_SESSION["alert"] = "Passwords do not match!<br/>";
			redirect("new_admin.php");
		}
		
		$fName = stripslashes($fName);
		$lName = stripslashes($lName);
		$user = stripslashes($user);
		$pass = stripslashes($pass);						//This function can be used to clean up data retrieved from a database or from an HTML form.
		$pass2 = stripslashes($pass2);
		
		$user = mysqli_real_escape_string($connection,$user);		//Escapes special characters in a string for use in an SQL statement
		$pass = mysqli_real_escape_string($connection,$pass);
		$pass2 = mysqli_real_escape_string($connection,$pass2);
		$fName = mysqli_real_escape_string($connection,$fName);
		$lName = mysqli_real_escape_string($connection,$lName);
		
		$presence_fields = array("user_name","password","confirm_password","first_name","last_name");
		validate_all_has_presences($presence_fields);
		
		$letter_spaces = array("first_name","last_name");
		validate_all_has_only_letters_spaces($letter_spaces);
		
		$min_fields = array("password" => 8);
		validate_all_minimum_lengths($min_fields);
		
		validate_password("password");
		
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("new_admin.php");
		}
		
		$sql = "SELECT Username FROM Admin WHERE Username='$user'";
		$result = mysqli_query($connection,$sql);
		
		if($result){
			if(mysqli_num_rows($result) != 0){
				$error = "Username '$user' already exists!<br/>";
				$_SESSION["alert"] = $error;
				redirect("new_admin.php");
			}
		}
		
		else{
			
		}
		
		$pass = crypt($pass);
		
		$sql = "INSERT INTO Admin VALUES('$user','$fName','$lName','$pass')";
		
		if(mysqli_query($connection, $sql)){
			$_SESSION["alert"] = "Admin created successfully. You can now signin below.<br/>";
			redirect("admin_signin.php");
		}
		else{
			$_SESSION["alert"] = "Failed to create admin!<br/>";
			redirect("new_admin.php");
		}
	
	}
	
	// did not get to page by clicking submit on sign up form
	else{
		redirect("new_admin.php");
	}
	
	//Close Connection
	if(isset($connection))
	{
		mysqli_close($connection);
	}
?>