<?php
	
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
?>