<?php

/*
	$host - This specifies the host name or IP address the application has to connect to.
	$user - This specifies the MySQL user.
	$pass - This specifies the MySQL password.
	$database - This specifies the the database to be used.
*/

$host = "mas-health.com";
$user = "xoyabepg_admin";
$pass = "Jack1$boss";
$database = "xoyabepg_medical";

/* Attempt to make a connection to the database. */

$connection = mysqli_connect($host, $user, $pass, $database);

/* Check if the connection was successful or not. */

if(mysqli_connect_errno())
{
	die("There was an error attempting to connect to the database: " . mysqli_connect_errno());
}

?>