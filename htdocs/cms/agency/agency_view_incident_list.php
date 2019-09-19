<html>
<head>
	<?php include('../classes/agencyController.php'); ?>

	<!----------Header----------->
	<?php include('agency_header.php');?>
</head>
<body>
	<!----------Top Navigation Bar-------->
	<?php include('agency_top_nav_bar.php');?>

	<!----------Side Navigation Bar-------->
	<?php include('../script/side_nav_bar.php');?>
	
	<!-----Fixed content for view incident page------->
	<?php include('agency_view_incident_list_header.php');?>
	
	<!----------------View Incident List-------------->
	<div class = "main-content">
	<div class="container">
	<div class="row">
	<div class="col-md-12">
	    <table class="table" id="table">
		<thead class="thead-light">
			<tr>
				<th scope="col" width="10%">ID</th>
				<th scope="col" >Name</th>
				<th scope="col" >Mobile No.</th>
				<th scope="col" >Location</th>
				<th scope="col" >Emergency Type</th>
				<th scope="col" >Assistance Type</th>
				<th scope="col" >Status</th>
				<th scope="col" width="15%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$agencyController = new agencyController();
				$openIncidentArray = $agencyController->getAllOpenIncidents();
				/* From incident db table
				0: incidentId, 1: name, 2: mobileNo, 3: location, 4: emergencyType, 5: typeOfAssistance, 6: remarks, 7: fileDateTime, 8: cco_username, 9: status, 10: statusDateTime
				*/
                foreach($openIncidentArray as $row ){
			?>
			<tr>
				<th scope="row"><?php echo $row["incidentId"]; ?></th>
				<td><?php echo $row["name"]; ?></td>
				<td><?php echo $row["mobileNo"]; ?></td>
				<td><?php echo $row["location"]; ?></td>
				<td><?php echo $row["emergencyType"]; ?></td>
				<td><?php echo $row["typeOfAssistance"]; ?></td>

				<td>
					<?php
						$checkStatusRecord = $agencyController->getStatus($row["incidentId"]); 
						if($checkStatusRecord == true ){ //i.e.: the status is "Resolved"
							echo("Resolved");
						}
						else{
							echo("In Progress");
						}
					?>
				</td>
				<!----------List of Actions----------->
				<td>
					<a href="agency_view_incident_details.php?viewMore=true&incidentId=<?php echo($row["incidentId"]) ?>" <i class="fas fa-eye"></i></a>
				</td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	</div>
	</div>
	</div>
	<!----------Footer----------->
	<div class = "main-content">
		<?php include('../includes/footer.php');?>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                "order": [[ 5, "asc" ]]
            } );
        } );
    </script>
</body>
</html>