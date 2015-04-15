<?php
	require_once('../includes/patient_session.php');
	require_once('../includes/database_connection.php');
?>
<?php
	$PatientID = $_SESSION["patient_login"]; 
	
	$eventsQuery = "SELECT * FROM Event WHERE PatientID=$PatientID";
	$eventsResult = mysqli_query($connection,$eventsQuery);
	
	
	if(!$eventsResult)
	{
		$_SESSION["alert"] = "An error occurred, cannot display patient events" . $PatientID;
		redirect("patient_dashboard.php");
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Choose Event</title>

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
                        <li><a href="update_patient_details.php"><i class="fa fa-gear fa-fw"></i> User Details</a>
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Choose Event</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<?php 
				$totalEvents = 1; 

				if($eventsResult->num_rows > 0)
				{
					while($row = $eventsResult->fetch_assoc())
					{
						$temp_id = $row["DoctorID"];
						$event_id = $row["EventID"];
								/* get doctor data*/
								$doctorQuery = "SELECT FirstName, LastName FROM Doctor WHERE DoctorID=$temp_id";
								$doctorResult = mysqli_query($connection,$doctorQuery);
								$doctorRow = $doctorResult->fetch_assoc();
								
						        echo  "<div class=\"row\">";

								
								echo "<div class=\"col-lg-12\">";
								
								
								echo "<div class=\"panel panel-primary\">";
								
								
								echo "<div class=\"panel-heading\">";
								echo "Event " . $totalEvents;
								$totalEvents++;
								echo "</div>";
								
								
								echo "<div class=\"panel-body\">";
								
								echo "<div class=\"table-responsive\">";
								
								
								echo "<table class=\"table table-striped table-bordered table-hover\" id=\"diagonses\">";
								
								echo "<thead><tr><td>Date</td><td>Doctor First Name</td><td>Doctor Last Name</td></tr></thead>";
								
								echo "<tbody>";
								
								echo "<tr>";
								
								echo "<td>";
									echo $row["EventDate"];
								echo "</td>";
								
								echo "<td>";
									echo $doctorRow["FirstName"];
								echo "</td>";
							
								echo "<td>";
									echo $doctorRow["LastName"];
								echo "</td>";
								
								echo "</tr>";
								
								echo "</tbody>";
								echo "</table>";
								echo "<form action=\"view_event_patient.php\" method=\"POST\">";
								echo "<input type=\"hidden\" name=\"eventid\" value=$event_id>";
								echo "<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">View This Event</button>";
								echo "</form>";
								echo "</div>";
								echo "</div>";
								echo "</div>";
								echo "</div>";
								echo "</div>";
					}
				}
			?>
			
            <div class="row">

            </div>
            <!-- /.row -->
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
