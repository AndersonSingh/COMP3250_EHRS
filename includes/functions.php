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
?>