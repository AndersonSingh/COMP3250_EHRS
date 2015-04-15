<?php require_once('../includes/doctor_session.php'); ?>
<?php require_once("../includes/database_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once('../includes/doctor_session.php'); ?>
<?php
	$patientID=$_SESSION["patient_login"];
	
	$patient_Query = "SELECT FirstName, LastName, DOB, ContactNumber
					  FROM Patient
					  WHERE patientID=$patientID";
	$result_patient = mysqli_query($connection,$patient_Query);

	$doctor_Query = "SELECT FirstName, LastName, Email, ContactNumber
                    FROM Doctor
                    WHERE doctorID= (SELECT DoctorID FROM HealthSummary WHERE patientID=$patientID)";
    $result_doctor = mysqli_query($connection,$doctor_Query);
	
	$medication_Query = "SELECT Medicine , Dosage , Indication , Comments , DatePrescribed
						FROM MEDICATIONHEALTHSUMMARY
						WHERE patientID=$patientID;";
	$result_medication = mysqli_query($connection,$medication_Query);
	
	$immunization_Query = "SELECT Disease , Vaccine , DateImmunized
						  FROM Immunization
						  WHERE patientID=$patientID;";
	$result_immunization = mysqli_query($connection,$immunization_Query);
	
	$adverse_Reaction_Query = "SELECT Substance , Manifestation
							  FROM AdverseReaction
							  WHERE patientID=$patientID;";
	$result_adverse = mysqli_query($connection,$adverse_Reaction_Query);
	
	$diagnosis_Query = "SELECT Diagnosis, DateOfOnset, Comments
					   FROM Diagnosis
					   WHERE patientID=$patientID;";
	$result_diagnose = mysqli_query($connection,$diagnosis_Query);
	
	if(!$result_patient || !$result_doctor || !$result_medication || !$result_immunization || !$result_adverse || !$result_diagnose)
	{
		$_SESSION["alert"] = "There was a problem retrieving data for this patient";
        redirect("doctor_dashboard.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title> View Health Summary </title>
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
                <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="doctor_dashboard.html"><i class="fa fa-dashboard fa-fw"></i>Doctor Dashboard</a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i>Search Patients</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i>View All Patients</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            
        </nav>
        
        <div id="page-wrapper">           
                <br>
                <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Overview of Patient Details
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
                                            if($result_patient->num_rows>0)
                                            {
                                                while($row = $result_patient->fetch_assoc())
                                                {
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
                    
                    <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Overview of Doctor Details
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
                                            if($result_doctor->num_rows>0)
                                            {
                                                while($row = $result_doctor->fetch_assoc())
                                                {
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
                    
                </div>
            
                <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Medication Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="medication">
                                    <thead>
                                      <tr>
                                        <th>Medicine</th>
                                        <th>Dosage</th>		
                                        <th>Indication</th>
                                        <th>Comments</th>
                                        <th>Date Prescribed</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            if($result_medication->num_rows>0)
                                            {
                                                while($row = $result_medication->fetch_assoc())
                                                {
                                                    echo "<tr>";

                                                    echo "<td>";
                                                    echo $row["Medicine"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Dosage"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Indication"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["Comments"];
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo $row["DatePrescribed"];
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
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Immunization Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="immunization">
                                      <tr>
                                        <th>Disease</th>
                                        <th>Vaccine</th>		
                                        <th>Date Immunized</th>
                                      </tr>

                                    <?php
                                            if($result_immunization->num_rows>0)
                                            {
                                                while($row = $result_immunization->fetch_assoc())
                                                {
                                                        echo "<tr>";

                                                        echo "<td>";
                                                        echo $row["Disease"];
                                                        echo "</td>";

                                                        echo "<td>";
                                                        echo $row["Vaccine"];
                                                        echo "</td>";

                                                        echo "<td>";
                                                        echo $row["DateImmunized"];
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
                <!-- /.col-lg-6 -->
            </div>
            
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Adverse Reaction Information
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
                                            if($result_adverse->num_rows>0)
                                            {
                                                while($row = $result_adverse->fetch_assoc())
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
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Diagnosis Information
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
                                            if($result_diagnose->num_rows>0)
                                            {
                                                while($row = $result_diagnose->fetch_assoc())
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
