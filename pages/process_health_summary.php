<?php session_start(); ?>
<?php require_once("../includes/database_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validations.php"); ?>

<?php
	/*
		Check to see if a post request was made. If so, we can obtain data and validate it and then store it in the database.
		If not, the use will be redirected to a blank health summary page.
	*/
	if(isset($_POST["submit"]))
	{
        //For passing of patientID and doctorID
        //$patientID = $_POST['patientID'];
		 //$patientID = $_POST['doctorID'];
        
        //Remove next line once linked to POST from create document!
        $patientID=1;
		$doctorID=1;

        //PULL DATA FROM MEDICATION TABLE
        $med_name= $_POST['med_medication_name']; 
        $med_dosage = $_POST['med_dosage'];
        $med_clinical = $_POST['med_clinical_indication'];
        $med_comments = $_POST['med_comments'];
        $med_date_prescribed = $_POST['med_date_prescribed'];

        $med_name = array_map('prepare_string', $med_name);
        $med_dosage = array_map('prepare_string', $med_dosage);
        $med_clinical = array_map('prepare_string', $med_clinical);
        $med_comments = array_map('prepare_string', $med_comments);
        $med_date_prescribed = array_map('prepare_string', $med_date_prescribed);

        validate_all_has_presences_med($med_name, $med_dosage, $med_clinical, $med_date_prescribed);
        
        
        //PULL DATA FROM IMMUNIZATION TABLE
        $immun_disease = $_POST['immun_disease']; 
        $immun_vaccine = $_POST['immun_vaccine'];
        $immun_date_prescribed = $_POST['immun_date_prescribed'];
        
        
        $immun_disease = array_map('prepare_string', $immun_disease);
        $immun_vaccine = array_map('prepare_string', $immun_vaccine);
        $immun_date_prescribed = array_map('prepare_string', $immun_date_prescribed);
        
        validate_all_has_presences_immun($immun_disease,  $immun_vaccine, $immun_date_prescribed);
        
        //PULL DATA FROM REACTIONS TABLE
        $adv_substance = $_POST['adv_substance']; 
        $adv_reaction = $_POST['adv_reaction'];
        
        $adv_substance = array_map('prepare_string', $adv_substance);
        $adv_reaction = array_map('prepare_string', $adv_reaction);
        
        validate_all_has_presences_reactions_health_summary($adv_substance, $adv_reaction);
        
        //PULL DATA FROM HISTORY TABLE
        $hist_diag = $_POST['hist_diagnosis'];
        $hist_comment = $_POST['hist_comment']; 
        $hist_date = $_POST['hist_date_prescribed'];
        
        $hist_diag = array_map('prepare_string', $hist_diag);
        $hist_comment = array_map('prepare_string', $hist_comment);
        $hist_date = array_map('prepare_string', $hist_date);
        
        validate_all_has_presences_hist($hist_diag, $hist_date );
        
        if(!empty($errors))
		{
			$_SESSION["errors"] = $errors;
			redirect("process_health_summary.php");
        }
        else{
             foreach($med_name as $pos =>$data){
                $add_Medication_Query = "INSERT INTO MEDICATIONHEALTHSUMMARY (Medicine , Dosage , Indication , Comments , DatePrescribed , PatientID)";
                $add_Medication_Query .= "VALUES('{$med_name[$pos]}','{$med_dosage[$pos]}','{$med_clinical[$pos]}','{$med_comments[$pos]}','{$med_date_prescribed[$pos]}' ,'{$patientID}' );"; 
                $result = mysqli_query($connection,$add_Medication_Query);
                if($result)
                {
                    $_SESSION["alert"] ="Rows in Medication table were successfully added." . "<br>";
                }
                else
                {
                    $_SESSION["alert"] = "Rows in Medication table were not successfully added.";
                    redirect("create_health_summary.php");
                }
             }
            
            foreach($immun_disease as $pos =>$data){
                $add_Immunization_Query="INSERT INTO IMMUNIZATION (Disease , Vaccine , DateImmunized , PatientID)";
                $add_Immunization_Query.="VALUES('{$immun_disease[$pos]}','{$immun_vaccine[$pos]}','{$immun_date_prescribed[$pos]}','{$patientID}'); ";
                $result = mysqli_query($connection,$add_Immunization_Query);
                if($result)
                {
                    $_SESSION["alert"] .="Rows in Immunization table were successfully added." . "<br>";
                }
                else
                {
                    $_SESSION["alert"] = "Rows in Immunization table were not successfully added.";
                    redirect("create_health_summary.php");
                }
             }
            
            foreach($adv_substance as $pos =>$data){
                $add_Reaction_Query="INSERT INTO ADVERSEREACTION (Substance , Manifestation , PatientID)";
                $add_Reaction_Query.=" VALUES('{$adv_substance[$pos]}','{$adv_reaction[$pos]}','{$patientID}')";
                $result = mysqli_query($connection,$add_Reaction_Query);
                if($result)
                {
                    $_SESSION["alert"] .="Rows in Adverse Reaction table were successfully added." . "<br>";
                }
                else
                {
                    $_SESSION["alert"] = "Rows in Adverse Reaction were not successfully added.";
                    redirect("create_health_summary.php");
                }
             }
            
            foreach($hist_diag as $pos =>$data){
                $add_History_Query = "INSERT INTO DIAGNOSIS (Diagnosis , DateOfOnSet , Comments , PatientID)";
                $add_History_Query .= "VALUES ('{$hist_diag[$pos]}','{$hist_date[$pos]}','{$hist_comment[$pos]}','{$patientID}') ";
                $result = mysqli_query($connection,$add_History_Query);
                if($result)
                {
                    $_SESSION["alert"] .="Rows in Diagnosis table were successfully added." . "<br>";
                }
                else
                {
                    $_SESSION["alert"] = "Rows in Diagnosis were not successfully added.";
                    redirect("create_health_summary.php");
                }
             }
			 $Health_Summary_Flag_Patient_Update = "UPDATE PATIENT SET SharedHealthFlag='Y' WHERE patientID= $patientID";
             $result = mysqli_query($connection,$Health_Summary_Flag_Patient_Update);
			 if($result)
			 {
				 $_SESSION["alert"] .="Patient Information Updated." . "<br>";
			 }
			 else
			 {
				 $_SESSION["alert"] ="Patient Information Not Updated" . "<br>";
				 redirect("create_health_summary.php");
			 }
			 
			 //Add information about creation into health summary table.
             $add_health_summary = "INSERT INTO HEALTHSUMMARY (PatientID, DoctorID, DateCreated)";
			 $add_health_summary .="VALUES ('{$patientID}','{$doctorID}',NOW())";
			 $result = mysqli_query($connection,$add_health_summary);
			 if($result)
             {
                  $_SESSION["alert"] .="Health Summary Info Added to System." . "<br>";
             }
			 else
             {
                  $_SESSION["alert"] = "Health Summary Info was not added to system";
                  redirect("create_health_summary.php");
             }
				
             redirect("create_health_summary.php");
            
        }  
	}
	else
	{
		redirect("create_health_summary.php");
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