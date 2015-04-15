<?php
	session_start();
	require_once("../includes/database_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validations.php");
?>

<?php
	
	if(isset($_POST["submit"])){
		
		/* PREPARE DATA */
		$oldPassword = mysqli_real_escape_string($connection,$_POST["old_password"]);
		$newPassword = mysqli_real_escape_string($connection,$_POST["new_password"]);
		$newPasswordConfirm = mysqli_real_escape_string($connection,$_POST["confirm_new_password"]);
		
		// check if passwords match
		if(strcmp($newPassword,$newPasswordConfirm) != 0){
			$_SESSION["alert"] = "Passwords do not match!<br/>";
			redirect("patient_change_password.php");
		}
		
		/* VALIDATE DATA HERE AND IF ERRORS STORE IN SESSION. */
		$presence_fields = array("old_password","new_password","confirm_new_password");
		validate_all_has_presences($presence_fields);
		
		$min_fields = array("new_password" => 8);
		validate_all_minimum_lengths($min_fields);
		
		// check that password is strong
		validate_password("new_password");
		
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("patient_change_password.php");
		}
		
		/* DO DATABASE QUERY. */
		
		// Get old password 
		
		$id = $_SESSION['patient_login'];
		$oldPasswordCheck = "SELECT * FROM Patient WHERE PatientID='$id'";
		
		$result = mysqli_query($connection,$oldPasswordCheck);
		
		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$hashed = $row["Password"];	
			$email = $row["Email"];

			// old password is correct
			if (crypt($oldPassword,$hashed) == $hashed){
				
				// hash new password to store in database
				$newPassword = crypt($newPassword);
				
				$updatePasswordQuery = "UPDATE Patient SET Password='$newPassword' WHERE PatientID='$id'";
				
				$result2 = mysqli_query($connection,$updatePasswordQuery);
				
				if($result2){
					//Prepare notification email.
					
					$firstName = $row["FirstName"];
					
					$to = $email;
					$subject = 'Mas-Health Password Change';
					$message = 'Hi, ' . $firstName . '! Your password has been successfully changed.' . "\n\n";
					$message .= 'If this was not done by you please contact us immediately!' . "\n";
					$message .= "\n" . 'Regards';
					$message .= "\n\n" . '*****This is an automatically generated message. Please do not reply to this e-mail as your message will not be received.*****';
					$headers  = 'From: Mas-Health <mas-health.com>' . "\r\n";
						//		'MIME-Version: 1.0' . "\r\n" .					// setting content-type in order to send emails with html tags.
						//		'Content-type: text/html; charset=utf-8';
						
					(mail($to, $subject, $message, $headers));						// send notification email
					
					// Recording that patient has changed random password
					
					$updatePasswordCheckQuery = "UPDATE Patient SET PasswordCheck='Y' WHERE PatientID='$id'";
					$result3 = mysqli_query($connection,$updatePasswordCheckQuery);
					
					$_SESSION["alert"] = "Password was successfully changed.";
					redirect("patient_dashboard.php");
				}
			}

				else{
					$_SESSION["alert"] = "Old Password is incorrect.";
					redirect("patient_change_password.php");
				}
		}
		
		else{
			$_SESSION["alert"] = "Password change was unsuccessful.";
			redirect("patient_dashboard.php");
		}		
	}
	
	else{
		redirect("patient_change_password.php");
	}

?>

<?php
	
	//Close database connection.

	if(isset($connection)){
		mysqli_close($connection);
	}

?>