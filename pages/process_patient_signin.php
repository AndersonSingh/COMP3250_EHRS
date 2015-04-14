<?php

session_start();
require_once('../includes/database_connection.php');
require_once("../includes/functions.php");
require_once("../includes/validations.php");

if(isset($_POST['submit'])){

	// Get data from login form
	$user = $_POST["email"];
	$pass = $_POST["password"];
	$captcha = $_POST["captcha"];

	// Protecting against attacks through SQL injection
	$user = stripslashes($user);
	$pass = stripslashes($pass);
	$captcha = stripslashes($captcha);											//This function can be used to clean up data retrieved from a database or from an HTML form.

	$user = mysqli_real_escape_string($connection,$user);		//Escapes special characters in a string for use in an SQL statement
	$pass = mysqli_real_escape_string($connection,$pass);
	$captcha = mysqli_real_escape_string($connection,$captcha);
	
	$presence_fields = array("email","password","captcha");
	validate_all_has_presences($presence_fields);
	
	if(!empty($errors)){
		$_SESSION["errors"] = $errors;
		redirect("patient_signin.php");
	}
	
	// all fields are present so check if captcha is correct
	
	$hashed_captcha = $_SESSION["captcha"];
	
	// captcha correct so proceed
	if(crypt($captcha,$hashed_captcha) == $hashed_captcha){
		
		// Query to obtain the hashed password stored in database of particular user.
		$check = "SELECT * FROM Patient WHERE Email='$user'";
		$result = mysqli_query($connection,$check);

		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$hashed = $row["Password"];	

			if(crypt($pass,$hashed) == $hashed){	
				//echo 'Password is valid!';
				$_SESSION['patient_login'] = $row["PatientID"]; 
				
				$changePassStatus = $row["PasswordCheck"];
				
				// User logging in for first time or still has not changed password
				if(strcmp($changePassStatus,"N") == 0){
					$_SESSION["alert"] = "Please change your password now!\n";
					redirect("patient_change_password.php");					// redirect to page to change password 
				}
				
				else{
					redirect("patient_dashboard.php");
				}
			}
			else{
				//echo 'Invalid password.';
				$_SESSION["alert"] = "Email or Password is invalid!<br/>";
				redirect("patient_signin.php");
			}
		}
	}
	else{
		$_SESSION["alert"] = "The code you have entered is incorrect, try again.<br/>";
		redirect("patient_signin.php");
	}

}

else{
	redirect("patient_signin.php");
}

//Close Connection
if(isset($connection))
	{
		mysqli_close($connection);
	}

?>