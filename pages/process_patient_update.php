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
		$birthDate = mysqli_real_escape_string($connection,$_POST["dob"]);
		$phone = mysqli_real_escape_string($connection,$_POST["contact_number"]);
		$emergencyName = mysqli_real_escape_string($connection,$_POST["emergency_name"]);
		$emergencyPhone = mysqli_real_escape_string($connection,$_POST["emergency_phone"]);
		$addressLine1 = mysqli_real_escape_string($connection,$_POST["address_line_1"]);
		$addressLine2 = mysqli_real_escape_string($connection,$_POST["address_line_2"]);
		$city = mysqli_real_escape_string($connection,$_POST["city"]);
		$email = mysqli_real_escape_string($connection, $_POST["email"]);
		
		/* VALIDATE DATA HERE AND IF ERRORS STORE IN SESSION. */
		$presence_fields = array("first_name","last_name","dob","contact_number","address_line_1","city","email");
		validate_all_has_presences($presence_fields);
		
		$min_fields = array("contact_number" => 7,"emergency_phone" => 7);
		validate_all_minimum_lengths($min_fields);
		
		$letter_spaces = array("first_name","last_name","emergency_name");
		validate_all_has_only_letters_spaces($letter_spaces);
		
		// If there exists any errors.
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("update_patient_details.php");
		}
		
		//DO DATABASE QUERY.
		
		$id = $_SESSION["patient_login"];
		
		$updatePatientQuery = "UPDATE Patient SET LastName='$lastName', ContactNumber='$phone', ";
		$updatePatientQuery .= "EmergencyContactName='$emergencyName', EmergencyContactNumber='$emergencyPhone', AddressLine1='$addressLine1', ";
		$updatePatientQuery .= "AddressLine2='$addressLine2', City='$city' WHERE PatientID='$id'";
		
		$result = mysqli_query($connection,$updatePatientQuery);
		
		if($result){
			$_SESSION["alert"] = "Personal Details were successfully updated.";
			redirect("patient_dashboard.php");
		}
		else
		{
			$_SESSION["alert"] = "Failed to update personal details.";
			redirect("patient_dashboard.php");
		}
		
	}
	
	else{
		redirect("update_patient_details.php");
	}
	
	//Close database connection.
	
	if(isset($connection))
	{
		mysqli_close($connection);
	}

?>