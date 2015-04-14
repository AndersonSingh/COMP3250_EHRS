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

	if(isset($_POST["submit"]))
	{
		/* PREPARE DATA */
		$firstName = mysqli_real_escape_string($connection,$_POST["first_name"]);
		$lastName = mysqli_real_escape_string($connection,$_POST["last_name"]);
		$addressLine1 = mysqli_real_escape_string($connection,$_POST["address_line_1"]);
		$addressLine2 = mysqli_real_escape_string($connection,$_POST["address_line_2"]);
		$city = mysqli_real_escape_string($connection,$_POST["city"]);
		$phone = mysqli_real_escape_string($connection,$_POST["contact_number"]);
		$birthDate = mysqli_real_escape_string($connection,$_POST["date_of_birth"]);
		$email = mysqli_real_escape_string($connection, $_POST["email"]);
		
		/* VALIDATE DATA HERE AND IF ERRORS STORE IN SESSION. */
		
		//Checking to see if all fields have data.
		
		$presence_fields = array("first_name","last_name","address_line_1","city","contact_number","date_of_birth","email");
		validate_all_has_presences($presence_fields);
		
		$min_fields = array("contact_number" => 7);
		validate_all_minimum_lengths($min_fields);
		    
		$date_fields = array("date_of_birth");
		validate_all_dates($date_fields);
		
		$letter_spaces = array("first_name","last_name");
		validate_all_has_only_letters_spaces($letter_spaces);
		
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("new_doctor.php");
		}
        
		//Generate Random Password
        $rand_pass = random_password(8);
	    $rand_pass_hashed = crypt($rand_pass);
	
        //Prepare notification email.
        
		$to = $email;
		$subject = 'MAS-HEALTH Doctor Account';
		$message = 'Hi, Dr. ' . $lastName . '! Your account has been successfully created. ';
		$message .= 'Please login at the link below using the following password: ' . $rand_pass . ".\n\n";
		$message .= 'matthewtestgame.host56.com/public/doctor_signin.php';
		$message .= "\n\n" . 'Please change your password as soon as you login!' . "\n";
		$message .= "\n" . 'Regards';
		$message .= "\n\n" . '*****This is an automatically generated message. Please do not reply to this e-mail as your message will not be received.*****';
		$headers  = 'From: MAS-HEALTH <mas-health.com>' . "\r\n";
			//		'MIME-Version: 1.0' . "\r\n" .					// setting content-type in order to send emails with html tags.
			//		'Content-type: text/html; charset=utf-8';
		
		/* DO DATABASE QUERY. */

		$addDoctorQuery = "INSERT INTO Doctor(FirstName, LastName, AddressLine1, AddressLine2, City, ContactNumber, DOB, Email, Password) ";
		$addDoctorQuery .= " VALUES ('{$firstName}', '{$lastName}', '{$addressLine1}', '{$addressLine2}', '{$city}', '{$phone}', '{$birthDate}','{$email}','{$rand_pass_hashed}')";
		$result = mysqli_query($connection,$addDoctorQuery);
		
		if($result)
		{
			(mail($to, $subject, $message, $headers));								// send notification email
			$_SESSION["alert"] ="Doctor was successfully added to database.";
			redirect("new_doctor.php");
		}
		else
		{
			$_SESSION["alert"] = "Doctor was not successfully added.";
			redirect("new_doctor.php");
		}
		
	}
	else
	{
		redirect("new_doctor.php");
	}

	?>

	<?php
	/*
		Close database connection.
	*/

	if(isset($connection))
	{
		mysqli_close($connection);
	}

?>