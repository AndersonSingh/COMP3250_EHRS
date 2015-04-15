<?php require_once('../includes/doctor_session.php'); ?>
<?php require_once("../includes/functions.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>New Health Summary</title>

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
        <script src="../includes/tablejs.js"></script>
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
            
        </nav>   
            
        <div id="page-wrapper">
                <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New Health Summary</h1>
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
                <form action="process_health_summary.php" class="register" method="POST">
                <br>
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Medication Information
                            </div>
                            <div class="panel-body">

                            <button type="button" class="btn btn-primary" onClick="addRow('datatable',10)" >Add Medication Record</button>
                            <button type="button" class="btn btn-primary" onClick="deleteRow('datatable')">Remove Medication Record</button>

                            <br />
                            <br/>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Medication Name</th>
                                                <th>Dosage</th>
                                                <th>Clinical Indication</th>
                                                <th>Comments</th>
                                                <th>Date Prescribed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input class="form-control"  name="med_medication_name[]">
                                                </td>
                                                <td>
                                                    <input class="form-control" name="med_dosage[]">
                                                </td>
                                                <td>
                                                    <input class="form-control" name="med_clinical_indication[]">
                                                </td>
                                                <td>
                                                    <input class="form-control" name="med_comments[]">
                                                </td>
                                                <td>
                                                    <input class="form-control" type ="date" name="med_date_prescribed[]">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    </div>

                      <br>   

                    <div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Immunization Information
						</div>
						<div class="panel-body">
							
						<button type="button" class="btn btn-primary" onClick="addRow('datatable2',10)" >Add Immunization Record</button>
						<button type="button" class="btn btn-primary" onClick="deleteRow('datatable2')">Remove Immunization Record</button>
						
						<br />
						<br/>
						
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="datatable2">
                                    <thead>
                                        <tr>
                                            <th>Disease</th>
                                            <th>Vaccine</th>
                                            <th>Date of Immunization</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
												<input class="form-control"  name="immun_disease[]">
											</td>
                                            <td>
												<input class="form-control" name="immun_vaccine[]">
											</td>

                                            <td>
												<input class="form-control" type="date" name="immun_date_prescribed[]">
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
				    </div>
				    </div>
                    </div>

                    <br>

                    <div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Adverse Reaction
						</div>
						<div class="panel-body">
							
						<button type="button" class="btn btn-primary" onClick="addRow('datatable3',10)" >Add Adverse Reaction Record</button>
						<button type="button" class="btn btn-primary" onClick="deleteRow('datatable3')">Remove Adverse Reaction Record</button>
						
						<br />
						<br/>
						
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="datatable3">
                                    <thead>
                                        <tr>
                                            <th>Substance</th>
                                            <th>Reaction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
												<input class="form-control"  name="adv_substance[]">
											</td>
                                            <td>
												<input class="form-control" name="adv_reaction[]">
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
                    </div>

                    <br>

                    <div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Medical History
						</div>
						<div class="panel-body">
							
						<button type="button" class="btn btn-primary" onClick="addRow('datatable4',10)" >Add Medical History Record</button>
						<button type="button" class="btn btn-primary" onClick="deleteRow('datatable4')">Remove Medical History Record</button>
						
						<br />
						<br/>
						
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="datatable4">
                                    <thead>
                                        <tr>
                                            <th>Diagnosis</th>
                                            <th>Date of Onset</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
												<input class="form-control"  name="hist_diagnosis[]">
											</td>
                                            <td>
												<input class="form-control" type="date" name="hist_date_prescribed[]">
											</td>
                                            <td>
												<input class="form-control" name="hist_comment[]">
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
                    </div>
                    <br>
			        <button type="submit" class="btn btn-primary" name="submit">Add New Health Summary</button>
        </form>
        <br>
        </div>
    </div>
	
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