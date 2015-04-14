<?php session_start(); ?>
<?php require_once("../includes/database_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validations.php"); ?>

<?php
	//print_r($_POST);

	if(isset($_POST["submit"]))
	{
		/* PREPARE DATA FOR INPUT */
		$synopsis = mysqli_real_escape_string($connection,$_POST["synopsis"]);
		
		/* when joining get this from post. */
		$PatientID = 1; 
		$DoctorID = 1;
		
		/* prepare data for the adverse reactions */
		$reaction_substances  = $_POST["substance"];
		$reaction_manifestations = $_POST["manifestation"];
			
		$reaction_substances = array_map('prepare_string', $reaction_substances);
		$reaction_manifestations = array_map('prepare_string', $reaction_manifestations);
			
			
		validate_all_has_presences_reactions($reaction_substances, $reaction_manifestations);
		
		
		
		/* prepare data for the medication table. */

		$medication_medications = $_POST["medication"];
		$medication_directions = $_POST["direction"];
		$medication_indications = $_POST["indication"];
		$medication_changetype = $_POST["changetype"];
		$medication_change = $_POST["change"];
		$medication_reason =  $_POST["reason"];
			
		$medication_medications = array_map('prepare_string', $medication_medications);
		$medication_directions = array_map('prepare_string',$medication_directions);
		$medication_indications = array_map('prepare_string',$medication_indications);
		$medication_changetype = array_map('prepare_string',$medication_changetype);
		$medication_change = array_map('prepare_string',$medication_change);
		$medication_reason = array_map('prepare_string',$medication_reason);
		
		validate_all_has_presences_medications($medication_medications, $medication_directions);
		
		/* prepare data for the diagnoses table */
		$diagnoses_problem = $_POST["problem"];
		$diagnoses_onset_date = $_POST["date"];
		$diagnoses_comment = $_POST["comment"];
			
		$diagnoses_problem = array_map('prepare_string', $diagnoses_problem);
		$diagnoses_onset_date = array_map('prepare_string', $diagnoses_onset_date);
		$diagnoses_comment= array_map('prepare_string', $diagnoses_comment);
		
			
		validate_all_has_presences_diagnoses($diagnoses_problem,$diagnoses_onset_date);
			
		
		/* validate data using custom written functions. */
		$presence_fields = array("synopsis");
		validate_all_has_presences($presence_fields);
		
		

	
		if(!empty($errors))
		{
			$_SESSION["errors"] = $errors;
			redirect("new_event.php");
		}

		
		/* Execute DB Query */
		
		
		/* update the patient data to show thier is a event associated. */
		$updatePatientQuery = "UPDATE Patient SET EventFlag='Y' WHERE PatientID='{$PatientID}'";
		
		$result = mysqli_query($connection,$updatePatientQuery);
		
		/* add event to db */
		
		$addEventQuery = "INSERT INTO EVENT(PatientID, DoctorID, EventDate, Synopsis) ";
		$addEventQuery .= " VALUES ('{$PatientID}', '{$DoctorID}', NOW(), '{$synopsis}')";
		
		$result = mysqli_query($connection,$addEventQuery);
		$currentEventID =  mysqli_insert_id($connection);
		echo $currentEventID;
		/* add reactions to db */

		foreach($reaction_substances as $key => $data)
		{
				$addReactionQuery = "INSERT INTO AdverseReaction (Substance, Manifestation, PatientID, EventID)";
				$addReactionQuery .="VALUES ('{$reaction_substances[$key]}', '{$reaction_manifestations[$key]}','{$PatientID}','{$currentEventID}')";
					
				$result = mysqli_query($connection,$addReactionQuery);	
		}
		
		/* add medications to db */
		foreach($medication_medications as $key => $data)
		{

				$addMedicationQuery = "INSERT INTO Medication (Medicine, Directions, Indication, ChangeType, Recommendation, Reason, PatientID, EventID)";
				$addMedicationQuery .="VALUES ('{$medication_medications[$key]}', '{$medication_directions[$key]}','{$medication_indications[$key]}', '{$medication_changetype[$key]}', '{$medication_change[$key]}','{$medication_reason[$key]}', '{$PatientID}','{$currentEventID}')";
					
				$result = mysqli_query($connection,$addMedicationQuery);	
		}
		
		
		
		/* add diagonsis to db */
		foreach($diagnoses_problem as $key => $data)
		{
			$addDiagnosesQuery = "INSERT INTO Diagnosis (Diagnosis, DateOfOnset, Comments, PatientID,EventID)";
			$addDiagnosesQuery .= "VALUES ('{$diagnoses_problem[$key]}', '{$diagnoses_onset_date[$key]}', '{$diagnoses_comment[$key]}', '{$PatientID}','{$currentEventID}')";
			
			$result = mysqli_query($connection,$addDiagnosesQuery);
		}
		
		
		if($result)
		{
			$_SESSION["alert"] ="Event was successfully added.";
			redirect("new_event.php");
		}
		else
		{
			$_SESSION["alert"] = "Event was not successfully added.";
			//redirect("doctor_dashboard.php");
		}
	}
	else
	{
		redirect("new_event.php");
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