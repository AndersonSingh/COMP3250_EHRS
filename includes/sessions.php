<?php

session_start();

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
?>