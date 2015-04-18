<?php
	ob_start();
	/*
		Any group member making use of the redirect function please ensure that output buffering is turned on. 
		More information is available from the PHP Manual : http://php.net/manual/en/book.outcontrol.php
	*/
	function redirect($address)
	{
		header("Location: ".$address);
		exit;
	}

	function prepare_string($data)
	{
		global $connection;
		$data = mysqli_real_escape_string($connection,$data);
		return $data;
	}
	
	
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div id=\"errorContent\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	/* 	This function will be used to display success and failure messages to the user.
		We set the $_SESSION["alert"] with the alert to be displayed when required. 
		We then call this function which will retrieve the alert from $_SESSION, 
		and wrap it in an html div. 
		
		The div is then returned to the calling page. 
	*/
	function displayAlert() {
		if (isset($_SESSION["alert"])) {
			$alert = "<div class=\"alert alert-info\">";
			$alert .= ($_SESSION["alert"]);
			$alert .= "</div>";
			
			$_SESSION["alert"] = null;
			
			return $alert;
		}
	}

	
	function displayErrors() {
		if (isset($_SESSION["errors"])) {
			$errors = $_SESSION["errors"];
			
			
			
			$output = "";
			
			$output .= "<div class=\"col-lg-12\">";
			$output .= "<div class=\"panel panel-red\">";
			$output .= "<div class=\"panel-heading\">Please Fix The Following Errors</div>";
			$output .= "<div class=\"panel-body\">";
			
							
							
			foreach ($errors as $key => $error) 
			{
				$output .= "<div class=\"alert alert-danger\">";
				$output .= htmlentities($error);
				$output .= "</div>";
			}
			
			$output.= "</div></div></div>";
			
			
			$_SESSION["errors"] = null;
			
			return $output;
		}
	}
	
	// this function generates a random password of a length of choice from the possible characters in the $chars variable 
	function random_password($length){
		$chars = "abcdefghijklmnopqrstuvwxyz123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%";
		$password = "";
		
		for($x=0;$x<$length;$x++){
			$password .= $chars[mt_rand(0,strlen($chars)-1)];
		}
		return $password;
	}
	
	// function to generate output when a patient is searched by a doctor. this output provides options for a doctor to deal with a patient's health summary and events.
	function build_search_display($health_sum, $event, $id){
		
		$output = "";
		
		$form_open = "<form id='build_search' role='form'>";
		
		$form_close = "</form>";
		
		$pass_hidden_id = "<div class='form-group'> <input form='build_search' type='hidden' name='patient_id' value='$id' class='form-control' /> </div>";
		
		$health_sum_create_btn = "<button form='build_search' type='submit' name='submit' formaction='create_health_summary.php' formmethod='post' class='btn btn-primary btn-lg btn-block'>Add Health Summary</button>";
		
		$view_health_sum_btn = "<button form='build_search' type='submit' name='submit' formaction='view_health_summary.php' formmethod='post' class='btn btn-primary btn-lg btn-block'>View Health Summary</button>";
		
		$event_add_btn = "<button form='build_search' type='submit' name='submit' formaction='new_event.php' formmethod='post' class='btn btn-primary btn-lg btn-block'>Add Event</button>";
		
		$event_view_btn = "<button form='build_search' type='submit' name='submit' formaction='choose_event.php' formmethod='post' class='btn btn-primary btn-lg btn-block'>View Events</button>";
		
		$output .= $form_open;
		$output .= $pass_hidden_id;
		
		if($health_sum == 0){
			$output .= "<div class='row'> " . $health_sum_create_btn . "</div> <br/><br/>";
		}
		
		else{
			$output .= "<div class='row'> " . $view_health_sum_btn . "</div><br/><br/>";
		}
		
		$output .= "<div class='row'> " . $event_add_btn . "</div><br/><br/>";
		
		if($event != 0){
			$output .= "<div class='row'> " . $event_view_btn . "</div><br/><br/>";
		}
		
		$output .= $form_close;
		
		return $output;
	}
	
	// returns the html output from build search display to the user
	function search_display(){
		
		$output = $_SESSION["search_display"];
		
		//$_SESSION["search_display"] = null;
		
		return $output;
	}
	
	// a view performed by a doctor on his/her personal details with option to update said details
	function doctor_details(){
		
		global $connection;
		
		$id = $_SESSION["doctor_login"];
		
		$sql = "SELECT * FROM Doctor WHERE DoctorID='$id';";
		
		$result = mysqli_query($connection,$sql);
		
		if($result){
			
		$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
		$firstName = $row["FirstName"];	
		$lastName = $row["LastName"];	
		$phone = $row["ContactNumber"];	
		$mail = $row["Email"];	
		$dob = $row["DOB"];	
		$addr1 = $row["AddressLine1"];	
		$addr2 = $row["AddressLine2"];
		$city = $row["City"];
		
		if($addr2 == ""){
			$addr2 = "nil";
		}
			
			$output = "<div class='panel panel-primary'>";
			$output .= "<div class='panel-heading'>";
			$output .= "Personal Information";
			$output .= "</div>";
			$output .= "<div class='panel-body'>";
			$output .= "<div class='table-responsive'>";
			$output .= "<table class='table table-striped table-bordered table-hover'>";
            $output .= "<thead>";
            $output .= "<tr>";
            $output .= "<th>First Name</th>";
            $output .= "<th>Last Name</th>";
            $output .= "<th>Telephone Contact Number</th>";
            $output .= "<th>Email</th>";
			$output .= "<th>Date of Birth</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
            $output .= "<tr>";
            $output .= "<td>$firstName</td>";
            $output .= "<td>$lastName</td>";
            $output .= "<td>$phone</td>";
            $output .= "<td>$mail</td>";
			$output .= "<td>$dob</td>";
            $output .= "</tr>";
            $output .= "</tbody>";
			$output .= "</table>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
							
			$output .= "<div class='panel panel-primary'>";
			$output .= "<div class='panel-heading'>";
			$output .= "Address Information";
			$output .= "</div>";
			$output .= "<div class='panel-body'>";
			$output .= "<div class='table-responsive'>";
			$output .= "<table class='table table-striped table-bordered table-hover'>";
			$output .= "<thead>";
			$output .= "<tr>";
            $output .= "<th>Address Line 1</th>";
            $output .= "<th>Address Line 2</th>";
            $output .= "<th>City</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
            $output .= "<tr>";
            $output .= "<td>$addr1</td>";
            $output .= "<td>$addr2</td>";
            $output .= "<td>$city</td>";
            $output .= "</tr>";
            $output .= "</tbody>";
            $output .= "</table>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
			
			$output .= "<form id='update'> </form>";
			
			$output .= "<button form='update' formaction='update_doctor_details.php' type='submit' class='btn btn-primary btn-lg'>Update Details</button>";
			
			$output .= "<br/><br/>";
			
			return $output;
		}
	}
	
	// performed by a doctor
	function view_all_patients(){
		
		global $connection;
		
		$sql = "SELECT * FROM Patient;";
		
		$result = mysqli_query($connection,$sql);
		$output = "";
		
		if($result){
			
			$output .= "<div class='panel panel-primary'>";
			$output .= "<div class='panel-heading'>";
			$output .= "Personal Information";
			$output .= "</div>";
			$output .= "<div class='panel-body'>";
			$output .= "<div class='table-responsive'>";
			$output .= "<table class='table table-striped table-bordered table-hover'>";
            $output .= "<thead>";
            $output .= "<tr>";
			$output .= "<th>Patient ID</th>";
            $output .= "<th>First Name</th>";
            $output .= "<th>Last Name</th>";
            $output .= "<th>Telephone Contact Number</th>";
            $output .= "<th>Email</th>";
			$output .= "<th>Date of Birth</th>";
			$output .= "<th>Emergency Contact Name</th>";
			$output .= "<th>Emergency Contact Number</th>";
			$output .= "<th>Address Line1</th>";
			$output .= "<th>Address Line2</th>";
			$output .= "<th>City</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
			
			while($row = mysqli_fetch_assoc($result)){
				
				$patientID = $row["PatientID"];
				$firstName = $row["FirstName"];	
				$lastName = $row["LastName"];	
				$phone = $row["ContactNumber"];	
				$mail = $row["Email"];	
				$dob = $row["DOB"];	
				$addr1 = $row["AddressLine1"];	
				$addr2 = $row["AddressLine2"];
				$city = $row["City"];
				$emerPhone = $row["EmergencyContactNumber"];	
				$emerName = $row["EmergencyContactName"];	
				
				if($addr2 == ""){
					$addr2 = "nil";
				}
				
				if($emerName == ""){
					$emerName = "nil";
				}
				
				if($emerPhone == ""){
					$emerPhone = "nil";
				}
				
				$output .= "<tr>";
				$output .= "<td>$patientID</td>";
				$output .= "<td>$firstName</td>";
				$output .= "<td>$lastName</td>";
				$output .= "<td>$phone</td>";
				$output .= "<td>$mail</td>";
				$output .= "<td>$dob</td>";
				$output .= "<td>$emerName</td>";
				$output .= "<td>$emerPhone</td>";
				$output .= "<td>$addr1</td>";
				$output .= "<td>$addr2</td>";
				$output .= "<td>$city</td>";
				$output .= "</tr>";
			}
		
            $output .= "</tbody>";
			$output .= "</table>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
			
			$output .= "<br/><br/>";
							
			return $output;
		}
	}
	
	// displays a doctor's personal details in a state ready to be updated
	function display_doctor_details(){
		
		global $connection;
		
		$id = $_SESSION["doctor_login"];
		
		$sql = "SELECT * FROM Doctor WHERE DoctorID='$id';";
		
		$result = mysqli_query($connection,$sql);
		
		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$firstName = $row["FirstName"];	
			$lastName = $row["LastName"];	
			$phone = $row["ContactNumber"];	
			$mail = $row["Email"];	
			$dob = $row["DOB"];	
			$addr1 = $row["AddressLine1"];	
			$addr2 = $row["AddressLine2"];
			$city = $row["City"];
			
			if($addr2 == ""){
				$addr2 = "nil";
			}
			
			$output = "<div class='row'>";
			$output .= "<div class='col-lg-6'>";
			$output .= "<form role='form' action='process_doctor_update.php' method='post'>";
			$output .= "<div class='form-group'>";
			$output .= "<label>First Name</label>";
			$output .= "<input type='text' name='first_name' class='form-control' value='$firstName' readonly>";
			$output .= "</div>";
			
			$output .= "<div class='form-group'>";
			$output .= "<label>Last Name</label>";
			$output .= "<input type='text' name='last_name' class='form-control' value='$lastName'>";
			$output .= "</div>";
								
			$output .= "<div class='form-group'>";
			$output .= "<label>Telephone Contact</label>";
			$output .= "<input type='text' name='contact_number' class='form-control' value='$phone'>";
			$output .= "</div>";
								
			$output .= "<div class='form-group'>";
			$output .= "<label>Email Address</label>";
			$output .= "<input type='email' name='email' class='form-control' value='$mail' readonly>";
			$output .= "</div>";
								
			$output .= "<div class='form-group'>";
			$output .= "<label>Date of Birth</label>";
			$output .= "<input type='date' name='date_of_birth' class='form-control' value='$dob' readonly>";
			$output .= "</div>";
								
			$output .= "</div>";
								
			$output .= "<div class='col-lg-12'>";
			$output .= "<h3 class='page-header'>Address Information</h3>";
			$output .= "</div>";
						
			$output .= "<div class='col-lg-6'>";
						
			$output .= "<div class='form-group'>";
			$output .= "<label>Address Line1</label>";
			$output .= "<input type='text' name='address_line_1' class='form-control' value='$addr1' >";
			$output .= "</div>";
							
			$output .= "<div class='form-group'>";
			$output .= "<label>Address Line2</label>";
			$output .= "<input type='text' name='address_line_2' class='form-control' value='$addr2'>";
			$output .= "</div>";
							
			$output .= "<div class='form-group'>";
			$output .= "<label>City</label>";
			$output .= "<input type='text' name='city' class='form-control' value='$city'>";
			$output .= "</div>";
							
			$output .= "<button type='submit' name='resubmit' class='btn btn-primary'>Save Changes</button>";
							
			$output .= "</div>";
			$output .= "</form>";
			$output .= "</div>";
			
			$output .= "<br/><br/>";
			
			$output .= "</div>";
			
			return $output;
		}
	}
	
	// a view performed by a patient on his/her personal details with option to update said details
	function patient_details(){
		
		global $connection;
		
		// if a patient is currently signed in
		if(isset($_SESSION["patient_login"])){
			$id = $_SESSION["patient_login"];
			// a view type of 1 means this is a call to view a patient's details from a signed in patient
			$viewType = 1;
		}
		
		// call to view patient details comes from a doctor that has just searched and found a patient
		else{
			$id = $_SESSION["patient_searched"];
			$viewType = 2;
		}
		
		
		
		$sql = "SELECT * FROM Patient WHERE PatientID='$id';";
		
		$result = mysqli_query($connection,$sql);
		
		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$firstName = $row["FirstName"];	
			$lastName = $row["LastName"];	
			$phone = $row["ContactNumber"];	
			$mail = $row["Email"];	
			$dob = $row["DOB"];	
			$addr1 = $row["AddressLine1"];	
			$addr2 = $row["AddressLine2"];
			$city = $row["City"];
			$emerPhone = $row["EmergencyContactNumber"];	
			$emerName = $row["EmergencyContactName"];	
			
			if($addr2 == ""){
				$addr2 = "nil";
			}
			
			if($emerName == ""){
					$emerName = "nil";
				}
				
			if($emerPhone == ""){
				$emerPhone = "nil";
			}
			
			$output = "<div class='panel panel-primary'>";
			$output .= "<div class='panel-heading'>";
			$output .= "Personal Information";
			$output .= "</div>";
			$output .= "<div class='panel-body'>";
			$output .= "<div class='table-responsive'>";
			$output .= "<table class='table table-striped table-bordered table-hover'>";
            $output .= "<thead>";
            $output .= "<tr>";
            $output .= "<th>First Name</th>";
            $output .= "<th>Last Name</th>";
            $output .= "<th>Telephone Contact Number</th>";
            $output .= "<th>Email</th>";
			$output .= "<th>Date of Birth</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
            $output .= "<tr>";
            $output .= "<td>$firstName</td>";
            $output .= "<td>$lastName</td>";
            $output .= "<td>$phone</td>";
            $output .= "<td>$mail</td>";
			$output .= "<td>$dob</td>";
            $output .= "</tr>";
            $output .= "</tbody>";
			$output .= "</table>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
			
			$output .= "<div class='panel panel-primary'>";
			$output .= "<div class='panel-heading'>";
			$output .= "Emergency Contact Information";
			$output .= "</div>";
			$output .= "<div class='panel-body'>";
			$output .= "<div class='table-responsive'>";
			$output .= "<table class='table table-striped table-bordered table-hover'>";
			$output .= "<thead>";
			$output .= "<tr>";
            $output .= "<th>Emergency Contact Name</th>";
            $output .= "<th>Emergency Contact Number</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
            $output .= "<tr>";
            $output .= "<td>$emerName</td>";
            $output .= "<td>$emerPhone</td>";
            $output .= "</tr>";
            $output .= "</tbody>";
            $output .= "</table>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
							
			$output .= "<div class='panel panel-primary'>";
			$output .= "<div class='panel-heading'>";
			$output .= "Address Information";
			$output .= "</div>";
			$output .= "<div class='panel-body'>";
			$output .= "<div class='table-responsive'>";
			$output .= "<table class='table table-striped table-bordered table-hover'>";
			$output .= "<thead>";
			$output .= "<tr>";
            $output .= "<th>Address Line 1</th>";
            $output .= "<th>Address Line 2</th>";
            $output .= "<th>City</th>";
            $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody>";
            $output .= "<tr>";
            $output .= "<td>$addr1</td>";
            $output .= "<td>$addr2</td>";
            $output .= "<td>$city</td>";
            $output .= "</tr>";
            $output .= "</tbody>";
            $output .= "</table>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
			
			if($viewType == 1){
				$output .= "<form id='update'> </form>";
			
				$output .= "<button form='update' formaction='update_patient_details.php' type='submit' class='btn btn-primary btn-lg'>Update Details</button>";
			}
			
			$output .= "<br/><br/>";
			
			return $output;
		}
	}
	
	// displays a patient's personal details in a state ready to be updated
	function display_patient_details(){
		
		global $connection;
		
		$id = $_SESSION["patient_login"];
		
		$sql = "SELECT * FROM Patient WHERE PatientID='$id';";
		
		$result = mysqli_query($connection,$sql);
		
		if($result){
			
			$row = mysqli_fetch_assoc($result);					// Get a result row as an associated array.
			$firstName = $row["FirstName"];	
			$lastName = $row["LastName"];	
			$phone = $row["ContactNumber"];	
			$mail = $row["Email"];	
			$dob = $row["DOB"];	
			$addr1 = $row["AddressLine1"];	
			$addr2 = $row["AddressLine2"];
			$city = $row["City"];
			$emerPhone = $row["EmergencyContactNumber"];	
			$emerName = $row["EmergencyContactName"];	
			
			if($addr2 == ""){
				$addr2 = "nil";
			}
			
			if($emerName == ""){
					$emerName = "nil";
				}
				
			if($emerPhone == ""){
				$emerPhone = "nil";
			}
			
			$output = "<div class='row'>";
			$output .= "<div class='col-lg-6'>";
			$output .= "<form role='form' action='process_patient_update.php' method='post'>";
			$output .= "<div class='form-group'>";
			$output .= "<label>First Name</label>";
			$output .= "<input type='text' name='first_name' class='form-control' value='$firstName' readonly>";
			$output .= "</div>";
			
			$output .= "<div class='form-group'>";
			$output .= "<label>Last Name</label>";
			$output .= "<input type='text' name='last_name' class='form-control' value='$lastName'>";
			$output .= "</div>";
								
			$output .= "<div class='form-group'>";
			$output .= "<label>Telephone Contact</label>";
			$output .= "<input type='text' name='contact_number' class='form-control' value='$phone'>";
			$output .= "</div>";
								
			$output .= "<div class='form-group'>";
			$output .= "<label>Email Address</label>";
			$output .= "<input type='email' name='email' class='form-control' value='$mail' readonly>";
			$output .= "</div>";
								
			$output .= "<div class='form-group'>";
			$output .= "<label>Date of Birth</label>";
			$output .= "<input type='date' name='dob' class='form-control' value='$dob' readonly>";
			$output .= "</div>";
								
			$output .= "</div>";
			
			$output .= "<div class='col-lg-12'>";
			$output .= "<h3 class='page-header'>Emergency Contact Information</h3>";
			$output .= "</div>";
			
			$output .= "<div class='col-lg-6'>";
						
			$output .= "<div class='form-group'>";
			$output .= "<label>Emergency Contact Name</label>";
			$output .= "<input type='text' name='emergency_name' class='form-control' value='$emerName' >";
			$output .= "</div>";
							
			$output .= "<div class='form-group'>";
			$output .= "<label>Emergency Contact Number</label>";
			$output .= "<input type='text' name='emergency_phone' class='form-control' value='$emerPhone' >";
			$output .= "</div>";
			
			$output .= "</div>";
								
			$output .= "<div class='col-lg-12'>";
			$output .= "<h3 class='page-header'>Address Information</h3>";
			$output .= "</div>";
						
			$output .= "<div class='col-lg-6'>";
						
			$output .= "<div class='form-group'>";
			$output .= "<label>Address Line1</label>";
			$output .= "<input type='text' name='address_line_1' class='form-control' value='$addr1' >";
			$output .= "</div>";
							
			$output .= "<div class='form-group'>";
			$output .= "<label>Address Line2</label>";
			$output .= "<input type='text' name='address_line_2' class='form-control' value='$addr2'>";
			$output .= "</div>";
							
			$output .= "<div class='form-group'>";
			$output .= "<label>City</label>";
			$output .= "<input type='text' name='city' class='form-control' value='$city'>";
			$output .= "</div>";
			
			$output .= "<button type='submit' name='resubmit' class='btn btn-primary'>Save Changes</button>";
			
			$output .= "</div>";
			
			$output .= "</form>";
			$output .= "</div>";
							
			$output .= "<br/><br/>";
							
			$output .= "</div>";
			
			return $output;
		}
	}
?>