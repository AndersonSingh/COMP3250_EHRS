<?php 
	session_start();
	require_once("../includes/database_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validations.php");
?>

<?php

	//print_r($_POST);
	/*
		Before beginning to process the form, check that the user arrived at create_patient.php with a POST request. 
		If the user did not make a POST request, then the $_POST[] is not set and a new patient cannot be created, redirect the user.
	*/

	if(isset($_POST["submit"])){
		
		/* PREPARE DATA */
		$user = mysqli_real_escape_string($connection,$_POST["email"]);
		
		/* VALIDATE DATA HERE AND IF ERRORS STORE IN SESSION. */
		$presence_fields = array("email");
		validate_all_has_presences($presence_fields);
		
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("doctor_forgot_password.php");
		}
		
		$sql = "SELECT * FROM Doctor WHERE Email='$user'";
		$result = mysqli_query($connection,$sql);
		
		if($result){
			if(mysqli_num_rows($result) == 0){
				$error = "The email '$user' does not exist in our system!<br/>";
				$_SESSION["alert"] = $error;
				redirect("doctor_forgot_password.php");
			}
			
			else{
				
				//Generate a Random Password
				$rand_pass = random_password(8);
				$rand_pass_hashed = crypt($rand_pass);
				
				// change user's password and make it to prompt user to change password on next login
				$update = "UPDATE Doctor SET Password='$rand_pass_hashed', PasswordCheck='N' WHERE Email='$user';";
				
				$result2 = mysqli_query($connection,$update);
				
				if($result2){
					
					// get name for email
					$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
					$lastName = $row["LastName"];	
					
					$to = $user;
					$subject = 'Mas-Health Password Reset';
					$message = 'Hi, Dr. ' . $lastName . '! Your password has been successfully reset. ' . "\n\n";
					$message .= 'Your new password is ' . $rand_pass . ".\n\n";
					$message .= 'You can login at the following link:' . "\n" . 'matthewtestgame.host56.com/public/patient_signin.php';
					$message .= "\n\n" . 'Please change your password as soon as you login!' . "\n";
					$message .= "\n" . 'Regards';
					$message .= "\n\n" . '*****This is an automatically generated message. Please do not reply to this e-mail as your message will not be received.*****';
					$headers  = 'From: Mas-Health <mas-health.com>' . "\r\n";
						//		'MIME-Version: 1.0' . "\r\n" .					// setting content-type in order to send emails with html tags.
						//		'Content-type: text/html; charset=utf-8';
					
					(mail($to, $subject, $message, $headers));						// send notification email
					$_SESSION["alert"] = "Your new password has been sent to your email.";
					redirect("doctor_forgot_password.php");
				}
			}
		}
		
	}
	
	else{
		redirect("doctor_forgot_password.php");
	}