<?php

require_once('../includes/database_connection.php');
require_once("../includes/functions.php");
require_once("../includes/validations.php");
session_start();

if(isset($_POST["submit"])){

	// Get data from login form
	$user = $_POST["user_name"];
	$pass = $_POST["password"];
	$captcha = $_POST["captcha"];

	// Protecting against attacks through SQL injection
	$user = stripslashes($user);
	$pass = stripslashes($pass);						//This function can be used to clean up data retrieved from a database or from an HTML form.
	$captcha = stripslashes($captcha);

	$user = mysqli_real_escape_string($connection,$user);		//Escapes special characters in a string for use in an SQL statement
	$pass = mysqli_real_escape_string($connection,$pass);
	$captcha = mysqli_real_escape_string($connection,$captcha);
	
	// Validation of fields entered	
	$presence_fields = array("user_name","password","captcha");
	validate_all_has_presences($presence_fields);
	
	if(!empty($errors)){
		$_SESSION["errors"] = $errors;
		redirect("admin_signin.php");
	}
	
	// all fields are present so check if captcha is correct
	
	$hashed_captcha = $_SESSION["captcha"];

	if(crypt($captcha,$hashed_captcha) == $hashed_captcha){								// captcha correct so proceed
	
		// Query to obtain the hashed password stored in database of particular user.
		$check = "SELECT * FROM Admin WHERE Username='$user'";
		$result = mysqli_query($connection,$check);

		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$hashed = $row["Password"];							
			
			if(crypt($pass,$hashed) == $hashed){
				//echo 'Password is valid!';
				$_SESSION['admin_login'] = $user; 
				redirect("admin_dashboard.php");
			}
			else{
				//echo 'Invalid password.';
				$_SESSION["alert"] = "Username or Password is invalid!<br/>";
				redirect("admin_signin.php");
			}
		}
	}
	
	else{																				// captcha incorrect
		$_SESSION["alert"] = "The code you have entered is incorrect, try again.<br/>";
		redirect("admin_signin.php");
	}
}

else{
	redirect("admin_signin.php");
}

//Close Connection
if(isset($connection))
	{
		mysqli_close($connection);
	}

?>