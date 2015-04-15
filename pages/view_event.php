<?php require_once('../includes/doctor_session.php'); ?>
<?php require_once("../includes/database_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php

	if(isset($_POST["submit"]))
	{
		$EventID = $_POST["eventid"];

	}
	else
	{
		$_SESSION["alerts"] = "You must select a event before it can be viewed.";
		//redirect("doctor_dashboard.php");
	}

?>

<?php 
	if(isset($EventID))
	{
		/* queries */

		$PatientIDQuery = "SELECT PatientID FROM Event WHERE EventID=$EventID";
		$DoctorIDQuery = "SELECT DoctorID FROM Event WHERE EventID=$EventID";

		$PatientIDResult = mysqli_query($connection,$PatientIDQuery);
		$DoctorIDResult = mysqli_query($connection,$DoctorIDQuery);

		$row = $PatientIDResult->fetch_assoc();
		$PatientID = $row["PatientID"];

		$row = $DoctorIDResult->fetch_assoc();
		$DoctorID = $row["DoctorID"];

		$patientQuery = "SELECT FirstName, LastName, DOB,ContactNumber FROM Patient WHERE PatientID=$PatientID";
		$patientResult = mysqli_query($connection,$patientQuery);

		$doctorQuery = "SELECT FirstName, LastName, Email, ContactNumber FROM Doctor WHERE DoctorID=$DoctorID";
		$doctorResult = mysqli_query($connection,$doctorQuery);

		$synopsisQuery = "SELECT Synopsis FROM Event WHERE EventID=$EventID";
		$SynopsisResult = mysqli_query($connection,$synopsisQuery);

		$reactionsQuery = "SELECT * FROM AdverseReaction WHERE EventID=$EventID";
		$reactionsResult = mysqli_query($connection,$reactionsQuery);

		$medicationQuery = "SELECT * FROM Medication WHERE EventID=$EventID";
		$medicationResult = mysqli_query($connection,$medicationQuery);

		$diagnosisQuery = "SELECT * FROM Diagnosis WHERE EventID =$EventID";
		$diagnosisResult = mysqli_query($connection,$diagnosisQuery);

		if(!($diagnosisResult || $medicationResult || $reactionsResult || $SynopsisResult || $doctorResult || $patientResult))
		{
					$_SESSION["alert"] = "An Error Occurred While Trying To View The Event.";
					//redirect("doctor_dashboard.php");
		}
	}
	else
	{
		$_SESSION["alert"] = "An Error Occurred While Trying To View The Event.";
		//redirect("doctor_dashboard.php");
	}


?>
<!DOCTYPE html>
<html>
	<head>
		<title> View Event </title>
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
                <a class="navbar-brand" href="index.html">Electronic Health Record System V1.0</a>
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
                        <li><a href="update_doctor_details.php"><i class="fa fa-gear fa-fw"></i> User Details</a>
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
                    <h1 class="page-header">View Event</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
                <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Patient Personal Details
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Date-of-Birth</th>
                                            <th>Contact Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
												
												$row = $patientResult->fetch_assoc();
										
                                                    echo "<tr>";

                                                    echo "<td>";
                                                    echo $row["FirstName"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["LastName"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["DOB"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["ContactNumber"];
                                                    echo "</td>";

                                                    echo "</tr>";
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    </div>
                    
                    <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
							Doctor Personal Details
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Contact No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
												
												$row = $doctorResult->fetch_assoc();
                                                    echo "<tr>";

                                                    echo "<td>";
                                                    echo $row["FirstName"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["LastName"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Email"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["ContactNumber"];
                                                    echo "</td>";

                                                    echo "</tr>";

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    </div>
                    
                </div>
				
				
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								Clinical Synopsis Description
							</div>
							<div class="panel-body">
								
								<textarea class="form-control" id="synopsis" rows="3" disabled>
								
								<?php
								
									$row = $SynopsisResult->fetch_assoc();
									
									echo $row["Synopsis"];

								
								?>
								
								</textarea>
								
							</div>
						</div>
						
						
					</div>
				</div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Adverse Reactions
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                               <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="adverse_reaction">
                                      <tr>
                                        <th>Substance</th>
                                        <th>Manifestation</th>	
                                      </tr>

                                    <?php
											
										
                                            if($reactionsResult->num_rows>0)
                                            {
                                                while($row = $reactionsResult->fetch_assoc())
                                                {
                                                        echo "<tr>";

                                                        echo "<td>";
                                                        echo $row["Substance"];
                                                        echo "</td>";

                                                        echo "<td>";
                                                        echo $row["Manifestation"];
                                                        echo "</td>";


                                                        echo "</tr>";

                                                }
                                            }
                                    ?>

                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            
			
			                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Medications
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="medication">
                                    <thead>
                                      <tr>
                                        <th>Medication</th>
                                        <th>Direction</th>		
                                        <th>Indication</th>
                                        <th>Change Type</th>
                                        <th>Change</th>
										<th>Reason For Change</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            if($medicationResult->num_rows>0)
                                            {
                                                while($row = $medicationResult->fetch_assoc())
                                                {
                                                    echo "<tr>";

                                                    echo "<td>";
                                                    echo $row["Medicine"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Directions"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Indication"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["ChangeType"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Recommendation"];
                                                    echo "</td>";
													
													echo "<td>";
                                                    echo $row["Reason"];
                                                    echo "</td>";
													
                                                    echo "</tr>";

                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
                
                
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Diagnoses/Interventions
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="diagnosis">
                                      <tr>
                                        <th>Diagnosis</th>
                                          <th>Date of Onset</th>
                                        <th>Comments</th>	
                                      </tr>

                                    <?php
                                            if($diagnosisResult->num_rows>0)
                                            {
                                                while($row = $diagnosisResult->fetch_assoc())
                                                {
                                                        echo "<tr>";

                                                        echo "<td>";
                                                        echo $row["Diagnosis"];
                                                        echo "</td>";

                                                        echo "<td>";
                                                        echo $row["DateOfOnset"];
                                                        echo "</td>";

                                                        echo "<td>";
                                                        echo $row["Comments"];
                                                        echo "</td>";

                                                        echo "</tr>";
                                                }
                                            }
                                    ?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

            </div>
        
		  </div>
        </div>
		
	</body>
</html>
