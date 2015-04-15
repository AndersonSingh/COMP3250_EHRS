<?php require_once('../includes/doctor_session.php'); ?>
<?php require_once("../includes/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add New Event</title>

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
	<script src="../js/tablejs.js"></script>
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
                        <li><a href="doctor_details.php"><i class="fa fa-user fa-fw"></i> User Details</a>
                        </li>
						<li><a href="update_doctor_details.php"><i class="fa fa-user fa-fw"></i>Edit User Details</a>
                        </li>
                        <li><a href="doctor_change_password.php"><i class="fa fa-gear fa-fw"></i> Change Password</a>
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
                            <a href="doctor_dashboard.php"><i class="fa fa-dashboard fa-fw"></i>Doctor Dashboard</a>
                        </li>
                        <li>
                            <a href="patient_search.php"><i class="fa fa-table fa-fw"></i>Search Patients</a>
                        </li>
                        <li>
                            <a href="view_all_patients.php"><i class="fa fa-edit fa-fw"></i>View All Patients</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New Event</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<?php 
				
				if(isset($_SESSION["alert"]))
				{
					echo displayAlert();
				}
				
				if(isset($_SESSION["errors"]))
				{
					echo displayErrors();
				}
				?>
			
			<div class="row">
			<form action="create_event.php" method="post">
			
				<div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Clinical Synopsis Description
						</div>
						<div class="panel-body">
								<textarea class="form-control" rows="3" name="synopsis" ></textarea>
						</div>
					</div>
				</div>
				
				
				
				<div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Adverse Reactions
						</div>
						<div class="panel-body">
							
						<button type="button" class="btn btn-primary" onClick="addRow('reactions',10)" >Add Adverse Reaction</button>
						<button type="button" class="btn btn-primary" onClick="deleteRow('reactions')">Remove Adverse Reaction</button>
						
						<br />
						<br/>
						
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="reactions">
                                    <thead>
                                        <tr>
                                            <th>Substance/Agent</th>
                                            <th>Manifestation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
												<input class="form-control" name="substance[]">
											</td>
                                            <td>
												<input class="form-control" name="manifestation[]">
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
				
				
					<div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Medications
						</div>
						<div class="panel-body">
							
						<button type="button" class="btn btn-primary" onClick="addRow('medications',10)" >Add Medication</button>
						<button type="button" class="btn btn-primary" onClick="deleteRow('medications')">Remove Medication</button>
						
						<br />
						<br/>
						
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="medications">
                                    <thead>
                                        <tr>
                                            <th>Medication</th>
                                            <th>Directions</th>
											<th>Indication</th>
											<th>Change Type</th>
											<th>Change</th>
											<th>Reason For Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
												<input class="form-control" name="medication[]">
											</td>
                                            <td>
												<input class="form-control" name="direction[]">
											</td>
											 <td>
												<input class="form-control" name="indication[]">
											</td>
                                            <td>
												<input class="form-control" name="changetype[]">
											</td>
											 <td>
												<input class="form-control" name="change[]">
											</td>
                                            <td>
												<input class="form-control" name="reason[]">
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>	
				</div>
						
						
						
						
				
				<div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Diagnoses/Interventions
						</div>
						<div class="panel-body">
							
						<button type="button" class="btn btn-primary" onClick="addRow('diagonses',10)" >Add Diagnoses</button>
						<button type="button" class="btn btn-primary" onClick="deleteRow('diagonses')">Remove Diagnoses</button>
						
						<br />
						<br/>
						
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="diagonses">
                                    <thead>
                                        <tr>
                                            <th>Problem/Diagnosis</th>
                                            <th>Date of Onset</th>
											<th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
												<input class="form-control" name="problem[]">
											</td>
                                            <td>
												<input class="form-control" type ="date" name="date[]">
											</td>
											<td>
												<input class="form-control" name="comment[]">
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
				
		<button type="submit" class="btn btn-primary" name="submit">Add New Event</button>
		<br />
		<br />
				
		</form>
		
		</div>
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
