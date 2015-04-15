<?php
	require_once('../includes/patient_session.php');
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Change Password</title>
		
		<!-- Bootstrap Core CSS -->
		<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="../dist/css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
		<link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>

	
	<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Electronic Health Record System v1.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="patient_details.php"><i class="fa fa-user fa-fw"></i> User Details</a>
                        </li>
						<li><a href="update_patient_details.php"><i class="fa fa-user fa-fw"></i>Edit User Details</a>
                        </li>
                        <li><a href="patient_change_password.php"><i class="fa fa-gear fa-fw"></i> Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="patient_dashboard.php"><i class="fa fa-dashboard fa-fw"></i>Patient Dashboard</a>
                        </li>
                        <li>
                            <a href="view_health_summary_patient.php"><i class="fa fa-table fa-fw"></i>View Health Summary</a>
                        </li>
                        <li>
                            <a href="view_events.php"><i class="fa fa-edit fa-fw"></i>View Events</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		
		<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Change Password</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				<?php 
				
					if(isset($_SESSION["alert"])){
						echo displayAlert();
					}
								
					if(isset($_SESSION["errors"])){
						echo displayErrors();
					}
				
				?>
				
				<div class="row">
					<div class="col-lg-6">
						<form role="form" action="process_patient_change_password.php" method="post">
							<div class="form-group">
								<input type="password" name="old_password" class="form-control" placeholder="Old Password">
							</div>
							
							<div class="form-group">
								<input type="password" name="new_password" class="form-control" placeholder="New Password">
							</div>
							
							<div class="form-group">
								<input type="password" name="confirm_new_password" class="form-control" placeholder="Re-enter New Password">
							</div>
							
							<button type="submit" name="submit" class="btn btn-primary">Confirm Change Password</button>
							
							<br/>
							<br/>
					
						</form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
		
	<!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	</body>
</html>		