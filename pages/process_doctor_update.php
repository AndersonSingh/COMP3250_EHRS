<?php
	session_start();
	require_once('../includes/database_connection.php');
	require_once('../includes/functions.php');
	require_once("../includes/validations.php");
?>

<?php
	
	if(isset($_POST["resubmit"])){
		
		// PREPARE DATA
		$firstName = mysqli_real_escape_string($connection,$_POST["first_name"]);
		$lastName = mysqli_real_escape_string($connection,$_POST["last_name"]);
		$addressLine1 = mysqli_real_escape_string($connection,$_POST["address_line_1"]);
		$addressLine2 = mysqli_real_escape_string($connection,$_POST["address_line_2"]);
		$city = mysqli_real_escape_string($connection,$_POST["city"]);
		$phone = mysqli_real_escape_string($connection,$_POST["contact_number"]);
		$birthDate = mysqli_real_escape_string($connection,$_POST["date_of_birth"]);
		$email = mysqli_real_escape_string($connection, $_POST["email"]);
		
		/* VALIDATE DATA HERE AND IF ERRORS STORE IN SESSION. */
		$presence_fields = array("first_name","last_name","date_of_birth","contact_number","address_line_1","city","email");
		validate_all_has_presences($presence_fields);
		
		$min_fields = array("contact_number" => 7);
		validate_all_minimum_lengths($min_fields);
		
		$letter_spaces = array("first_name","last_name");
		validate_all_has_only_letters_spaces($letter_spaces);
		
		// If there exists any errors.
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("update_doctor_details.php");
		}
		
		//DO DATABASE QUERY.
		
		$id = $_SESSION["doctor_login"];
		
		$updateDoctorQuery = "UPDATE Doctor SET LastName='$lastName', ContactNumber='$phone', ";
		$updateDoctorQuery .= "AddressLine1='$addressLine1', ";
		$updateDoctorQuery .= "AddressLine2='$addressLine2', City='$city' WHERE DoctorID='$id'";
		
		$result = mysqli_query($connection,$updateDoctorQuery);
		
		if($result){
			$_SESSION["alert"] = "Personal Details were successfully updated.";
			redirect("doctor_dashboard.php");
		}
		else
		{
			$_SESSION["alert"] = "Failed to update personal details.";
			redirect("doctor_dashboard.php");
		}
		
	}
	
	else{
		redirect("update_doctor_details.php");
	}
	
	//Close database connection.
	
	if(isset($connection))
	{
		mysqli_close($connection);
	}

?>