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
			redirect("admin_change_password.php");
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
			redirect("admin_change_password.php");
		}
		
		/* DO DATABASE QUERY. */
		
		// Get old password 
		
		$id = $_SESSION['admin_login'];
		$oldPasswordCheck = "SELECT * FROM Admin WHERE Username='$id'";
		
		$result = mysqli_query($connection,$oldPasswordCheck);
		
		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$hashed = $row["Password"];	

			// old password is correct
			if (crypt($oldPassword,$hashed) == $hashed){
				
				// hash new password to store in database
				$newPassword = crypt($newPassword);
				
				$updatePasswordQuery = "UPDATE Admin SET Password='$newPassword' WHERE Username='$id'";
				
				$result2 = mysqli_query($connection,$updatePasswordQuery);
				
				if($result2){
					$_SESSION["alert"] = "Password was successfully changed.";
					redirect("admin_dashboard.php");
				}
			}

				else{
					$_SESSION["alert"] = "Old Password is incorrect.";
					redirect("admin_change_password.php");
				}
		}
		
		else{
			$_SESSION["alert"] = "Password change was unsuccessful.";
			redirect("admin_dashboard.php");
		}		
	}
	
	else{
		redirect("admin_change_password.php");
	}

?>

<?php
	
	//Close database connection.

	if(isset($connection)){
		mysqli_close($connection);
	}

?>