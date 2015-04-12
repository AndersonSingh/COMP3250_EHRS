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
	
	$month = $dateSplit[0];
	$day   = $dateSplit[1];
	$year  = $dateSplit[2];
	
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

?>