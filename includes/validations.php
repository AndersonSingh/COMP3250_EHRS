<?php


$errors = array();

/*
	It is recommended that anyone interested in developing additional validation functions read this article on regular expressions.
	http://webcheatsheet.com/php/regular_expressions.php
 */
function field_has_only_letters_spaces($data)
{
	/*
		The regular expression matches 0 or more expressions containing a letter(upper-case and lower-case) and space.
		
	*/
	if(preg_match("/^[a-zA-Z ]*$/", $data))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function field_has_date($data)
{
	if((int) $data === 0)
	{
		return false;
	}
	
	$dateSplit = explode('-', $data);
	
	$year = $dateSplit[0];
	$month   = $dateSplit[1];
	$day  = $dateSplit[2];
	
	if(checkdate($month,$day,$year))
	{
		return true;
	}
	else
	{
		return false;
	}
	
}

function field_has_presence($data)
{
	if(isset($data) && $data !== "")
	{
		return true;
	}
	else
	{
		return false;
	}
}

function field_has_maximum_length($data, $max_length)
{
	if(strlen($data) <= $max_length)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function field_has_minimum_length($data, $min_length)
{
	if(strlen($data) >= $min_length)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function validate_all_has_presences($all_fields)
{
	global $errors;
	
	foreach($all_fields as $current_field)
	{
		$value = trim($_POST[$current_field]);
		if(!field_has_presence($value))
		{
			$errors[$current_field] = remove_underscore($current_field) . " cannot be blank.";
		}
	}
}

function validate_all_maximum_lengths($all_fields)
{
	global $errors;
	
	foreach($all_fields as $current_field => $max_length)
	{
		$value = trim($_POST[$current_field]);
		
		if(!field_has_maximum_length($current_field, $max_length))
		{
			$errors[$current_field] = remove_underscore($current_field) . " can be no longer than " . $max_length . " characters";	
		}
	}
}


function validate_all_minimum_lengths($all_fields)
{
	global $errors;
	
	foreach($all_fields as $current_field => $min_length)
	{
		$value = trim($_POST[$current_field]);
		if(!field_has_minimum_length($current_field, $min_length))
		{
			$errors[$current_field . "Min Field"] = /*remove_underscore($current_field)*/ $current_field . " can be no shorter than " . $min_length . " characters";
		}
	}
}

function validate_all_has_only_letters_spaces($all_fields)
{
	global $errors;
	foreach($all_fields as $current_field)
	{
		$value = trim($_POST[$current_field]);
		if(!field_has_only_letters_spaces($value))
		{
			$errors[$current_field] = remove_underscore($current_field) . " can contain only letters and spaces.";
		}
	}
}

function validate_all_dates($all_fields)
{
	global $errors;
	foreach($all_fields as $current_field)
	{
		$value = trim($_POST[$current_field]);
		
		if(!field_has_date($value))
		{
			$errors[$current_field] = $current_field . " is not a valid date of birth.";
		}
	}
}

/* Helper function obtained online which makes displaying errors neater. */
function remove_underscore($field) {
  $field = str_replace("_", " ", $field);
  $field = ucfirst($field);
  return $field;
}

function validate_all_has_presences_reactions($reaction_substances, $reaction_manifestations)
{
	global $errors;
	
	foreach($reaction_substances as $key => $data)
	{

		$reaction_current_substance = trim($reaction_substances[$key]);
		$reaction_current_manifestation = trim($reaction_manifestations[$key]);
			
		if(!field_has_presence($reaction_current_substance))
		{
			$errors["Reactions Substance " . $key] = "The Substance on row " . ($key + 1) . " cannot be blank";
		}
		if(!field_has_presence($reaction_current_manifestation))
		{
			$errors["Reactions Manifestation " . $key] = "The Manifestation on row " . ($key + 1) . " cannot be blank";
		}
	}
}

function validate_all_has_presences_medications($medication_medications, $medication_directions)
{
	global $errors; 
		
	foreach($medication_medications as $key => $data)
	{

		$medication_current_medication = trim($medication_medications[$key]);
		$medication_current_directions = trim($medication_directions[$key]);
				
		if(!field_has_presence($medication_current_medication))
		{
			$errors["Medication Medication " . $key] = "The medication on row " . ($key + 1) . " cannot be blank.";
		}
				
		if(!field_has_presence($medication_current_directions))
		{
			$errors["Medication Directions " . $key] = "The directions on row " . ($key + 1) . " cannot be blank.";
		}
	
	}
	
}

function validate_all_has_presences_diagnoses($diagnoses_problem, $diagnoses_onset_date)
{
	global $errors;

	foreach($diagnoses_problem as $key => $data)
	{

		$diagnoses_current_problem = trim($diagnoses_problem[$key]);
		$diagnoses_current_onset_date = trim($diagnoses_onset_date[$key]);
			
		if(!field_has_presence($diagnoses_current_problem))
		{
			$errors["Diagnoses Problem " . $key] = "The diagnoses on row " . ($key + 1) . " cannot be blank.";
		}
				
		if(!field_has_presence($diagnoses_current_onset_date))
		{
			$errors["Diagnoses Date" . $key] = "The onset date on row " . ($key + 1) . " cannot be blank.";
		}
	}
	
}

function validate_all_has_presences_med($med_name, $med_dosage, $med_clinical, $med_date_prescribed)
{
    global $errors;
    foreach($med_name as $pos => $data)
    {
        $med_curr_name = trim($med_name[$pos]);
        $med_curr_dosage = trim($med_dosage[$pos]);
        $med_curr_clinical = trim($med_clinical[$pos]);
        $med_curr_date_prescribed = trim($med_date_prescribed[$pos]);
        if(!field_has_presence($med_curr_name))
        {
            $errors["Medicine Name Problem" . $pos] = "The medication name on row " . ($pos + 1) . " cannot be blank.";
        }
        if(!field_has_presence($med_curr_dosage))
        {
            $errors["Medicine DOsage Problem " . $pos] = "The medication dosage on row " . ($pos + 1) . " cannot be blank.";
        }
        if(!field_has_presence($med_curr_clinical))
        {
            $errors["Medicine Clinical Indication Problem " . $pos] = "The medication's clinical indication on row " . ($pos + 1) . " cannot be blank.";
        }
        if(!field_has_presence($med_curr_date_prescribed))
        {
            $errors["Medicine Date Prescribed Problem " . $pos] = "The medication's date on row " . ($pos + 1) . " cannot be blank.";
        }
    }
}

function validate_all_has_presences_immun($immun_disease,  $immun_vaccine, $immun_date_prescribed)
{
    global $errors;
    foreach($immun_disease as $pos =>$data)
    {
        $immun_curr_disease = trim($immun_disease[$pos]);
        $immun_curr_vaccine = trim($immun_vaccine[$pos]);
        $immun_curr_date_prescribed = trim($immun_date_prescribed[$pos]);
        if(!field_has_presence($immun_curr_disease))
        {
            $errors["Disease Name Problem" . $pos] = "The disease name on row " . ($pos + 1) . " cannot be blank.";
        }
        if(!field_has_presence($immun_curr_vaccine))
        {
            $errors["Vaccine Name Problem" . $pos] = "The vaccine name on row " . ($pos + 1) . " cannot be blank.";
        }
        if(!field_has_presence($immun_curr_date_prescribed))
        {
            $errors["Prescription date Problem" . $pos] = "The prescription date on row " . ($pos + 1) . " cannot be blank.";
        }
    }
}

function validate_all_has_presences_reactions_health_summary($adv_substance, $adv_reaction)
{
    global $errors;
    foreach($adv_substance as $pos =>$data)
    {
        $adv_curr_substance = trim ($adv_substance[$pos]);
        $adv_curr_reaction = trim ($adv_reaction[$pos]);
        if(!field_has_presence($adv_curr_substance))
        {
            $errors["Substance Name Problem" . $pos] = "The substance name on row " . ($pos + 1) . " cannot be blank.";
        }
        if(!field_has_presence($adv_curr_reaction))
        {
            $errors["Reaction description Problem" . $pos] = "The reaction description on row " . ($pos + 1) . " cannot be blank.";
        }
    }
}

 function validate_all_has_presences_hist($hist_diag, $hist_date)
 {
    global $errors;
     foreach($hist_diag as $pos =>$data)
     {
         $hist_curr_diag = trim($hist_diag[$pos]);
         $hist_curr_date = trim($hist_date[$pos]);
         if(!field_has_presence($hist_curr_diag))
         {
            $errors["Diagnosis Problem" . $pos] = "The diagnosis field on row " . ($pos + 1) . " cannot be blank.";
         }
         if(!field_has_presence($hist_curr_date))
         {
            $errors["Diagnosis date Problem" . $pos] = "The diagnosis date field on row " . ($pos + 1) . " cannot be blank.";
         }
     }
 }
 
 function has_number($data){
	if(preg_match("/[0-9]+/",$data)){
		return true;
	}
	return false;
}

function has_special_char($data){
	if(preg_match("/[^A-Za-z0-9]/",$data)){
		return true;
	}
	return false;
}

function has_lower_case($data){
	if(preg_match("/[a-z]+/",$data)){
		return true;
	}
	return false;
}

function has_upper_case($data){
	if(preg_match("/[A-Z]+/",$data)){
		return true;
	}
	return false;
}

function validate_password($field){
	
	global $errors;
	
	$value = $_POST[$field];
	
	if(!has_number($value)){
		$errors[$field . "_number"] = "Password must contain at least one number.";
	}
	
	if(!has_special_char($value)){
		$errors[$field . "_symbol"] = 'Password must contain at least one special symbol e.g ~,!,@,#,$,%,^,&,*,(,),etc.';
	}
	
	if(!has_lower_case($value)){
		$errors[$field . "_lower"] = "Password must contain at least one lower case letter.";
	}
	
	if(!has_upper_case($value)){
		$errors[$field . "_upper"] = "Password must contain at least one upper case letter.";
	}
}

?>