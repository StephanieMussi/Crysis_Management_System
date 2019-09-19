<html>
<body>
	<!----------------View Incident List-------------->
	<div class = "main-content">
	<div class="container">
	<div class="row">
	<div class="col-md-12">
		<br/>
		<?php
			if(isset($_GET['result'])){
				if($_GET['result'] == 'success'){
					echo '<div class="alert alert-success" role="alert">
  							Request has been submitted successfully.
						</div>';
				}
			}
			else if(isset($_GET['error'])){
				if($_GET['error'] == 'sqlError'){
					echo '<div class="alert alert-danger" role="alert">
 	 						Database connection error. Please try again later
						</div>';
				}
				else if($_GET['error'] == 'viewSentRequestError'){
					echo '<div class="alert alert-danger" role="alert">
 	 						Database execution error. Please try again later
						</div>';
				}
			}
		?>
		<h3 class="label">Incident List</h3>
		<!--------Table Filter----------->
		<center>
			<a href="agency_view_incident_list.php" class="btn btn-outline-success">All</a>
			<a href="agency_view_incident_list_fire.php" class="btn btn-outline-danger">Fire</a>
			<a href="agency_view_incident_list_gas_leak.php" class="btn btn-outline-secondary">Gas Leak</a>
			<a href="agency_view_incident_list_terrorist_attack.php" class="btn btn-outline-warning">Terrorist Attack</a>
			<a href="agency_view_incident_list_traffic_accident.php" class="btn btn-outline-info">Traffic Accident</a>
			<a href="agency_view_incident_list_natural_disasters.php" class="btn btn-outline-dark">Natural Disaster</a>
			<a href="agency_view_incident_list_others.php" class="btn btn-outline-primary">Others</a>
		</center>
	</div>
	</div>
	</div>
	</div>
</body>
</html>