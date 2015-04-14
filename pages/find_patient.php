<?php
	session_start();
	require_once("../includes/database_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validations.php");
?>

<?php
	
	if(isset($_POST['submit'])){
		
		$id = mysqli_real_escape_string($connection,$_POST["patient_id"]);
		
		$presence_fields = array("patient_id");
		validate_all_has_presences($presence_fields);
		
		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect("patient_search.php");
		}
		
		$sql = "SELECT * FROM Patient WHERE PatientID = '$id';";
		
		$result = mysqli_query($connection,$sql);
		
		if($result){
			if(mysqli_num_rows($result) != 0){
				$row = mysqli_fetch_assoc($result);
				
				if($row["SharedHealthFlag"] == 'N')
					$summary = 0;
				else
					$summary = 1;
					
				if($row["EventFlag"] == 'N')
					$event = 0;
				else
					$event = 1;
				
				$_SESSION["search_display"] = build_search_display($summary, $event, $id);
				
				if(isset($_SESSION["search_display"])){ 
					$_SESSION["patient_searched"] = $id;
				}
				redirect("patient_search.php");
			}
			
			else{
				$_SESSION["search_display"] = null;
				$_SESSION["alert"] = "Patient ID $id does not exist in database!";
				redirect("patient_search.php");
			}
		}
	}
	
	else{
		redirect("patient_search.php");
	}
	
?>