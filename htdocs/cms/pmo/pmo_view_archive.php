<html>
<head>
	<?php include('../classes/pmoController.php'); ?>
	<!----------Header----------->
	<?php include('pmo_header.php');?>
</head>
<body>
	<!----------Top Navigation Bar-------->
	<?php include('pmo_top_nav_bar.php');?>

	<!----------Side Navigation Bar-------->
	<?php include('../script/side_nav_bar.php');?>

	<!----------------Approve incident list-------------->
	<div class = "main-content">
	<div class="container">
	<div class="col-md-12">
	<div class="row">
		<h3 class="label">Archive </h3>
	</div>
	<div class="row">
		<p>These are the list of incidents that have been resolved</p>
	</div><br/>

	<!------------Resolved incident table--------------->
	<div class="row">
		<table class="table" id="table">
			<thead class="thead-light">
			<tr>
				<th scope="col" width="5%">ID</th>
				<th scope="col">Location</th>
				<th scope="col">Emergency Type</th>
				<th scope="col">Assistance Type</th>
				<th scope="col" width="15%">Severity Level</th>
				<th scope="col"width="10%">Status</th>
				<th scope="col" width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$incidentController = new pmoController();
				//$incidentController->setAccessToken("pmo");
				$openIncidentArray = $incidentController->getAllClosedIncidents();
				/* From incident db table
				0: incidentId, 1: name, 2: mobileNo, 3: location, 4: emergencyType, 5: typeOfAssistance, 6: remarks, 7: fileDateTime, 8: cco_username, 9: status, 10: statusDateTime
				*/
                foreach($openIncidentArray as $row)
                {
					//$severeCaseController = new severeIncidentController();
					//$severeCaseController->setAccessToken("pmo");
					$isSevere = $incidentController->isSevere($row["incidentId"]);
					$hasPmoResponded = $incidentController->hasPmoResponded($row["incidentId"]);
					if($isSevere == true && $hasPmoResponded == true){
						$result = $incidentController->getSpecificSevereCase($row["incidentId"]); //returns severeCaseObj
			?>
						<tr>
							<th scope="row"><?php echo $row["incidentId"]; ?></th>
							<td><?php echo $row["location"]; ?></td>
							<td><?php echo $row["emergencyType"]; ?></td>
							<td><?php echo $row["typeOfAssistance"]; ?></td>
							<td><?php echo $result->getSeverityLevel(); ?></td>
							<td><span class="btn btn-secondary disabled">Closed</span></td>
							<td><a href="pmo_resolved_view_more_info.php?action=viewArchive&incidentId=<?php echo $row["incidentId"]; ?>"><i class="fas fa-eye"></i></a></td>
						</tr>
			<?php
					}
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