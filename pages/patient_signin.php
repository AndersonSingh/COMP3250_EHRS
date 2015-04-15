<?php
	session_start();
	require_once("../includes/functions.php");

	if(isset($_SESSION['patient_login'])){						// if already logged in
		redirect("patient_dashboard.php");
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Patient Login</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/styles.css" rel="stylesheet">
		<link href="../dist/css/sb-admin-2.css" rel="stylesheet">
	</head>
	
	<body>
	
	<!--login modal-->
		<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="text-center">Patient Login</h1>
							<?php
								if(isset($_SESSION["alert"])){
									echo displayAlert();				
								}
									
								if(isset($_SESSION["errors"])){
									echo displayErrors();
								}
							?>
					</div>
					
					<div class="modal-body">
						<form class="form col-md-12 center-block" action="process_patient_signin.php" method="post">
							<div class="form-group">
								<input type="text" name="email" class="form-control input-lg" placeholder="Email">
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control input-lg" placeholder="Password">
							</div>
			
							<div class="form-group">
								<p>
									Enter the text you see in the image:
								</p>
			
								<p>
									<img id="captcha" src="../includes/captcha.php" alt="CAPTCHA">
									<small><a href="#" onclick="document.getElementById('captcha').src='../includes/captcha.php?';">reload image</a></small>
								</p>
				
								<input type="text" name="captcha" class="form-control input-lg" placeholder="Capthca"/>
							</div>
			
							<div class="form-group">
								<button name="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
								<span><a href="patient_forgot_password.php">Forgot your Password?</a></span>
							</div>
						</form>
					</div>
					
					<div class="modal-footer">
						<div class="col-md-12">
							<form id='cancel'>
								<button class="btn" data-dismiss="modal" aria-hidden="true" form="cancel" formaction="login_home.php">Cancel</button>
							</form>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>