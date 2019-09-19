<html>
<head>
	<?php include('../classes/agencyController.php'); ?>

	<!----------Header----------->
	<?php include('agency_header.php');?>
</head>
<body onload="fillFunction()">
	<!----------Top Navigation Bar-------->
	<?php include('agency_top_nav_bar.php');?>

	<!----------Side Navigation Bar-------->
	<?php include('../script/side_nav_bar.php');?>
	
	<?php
		if($_GET['viewMore'] != "true"){
			header("Location: agency_view_incident_list.php");
			exit();
		}
	?>

	<!----------------View incident list-------------->
	<div class = "main-content">
	<div class="container">
	<div class="col-md-12">
	<div class="row">
		<h3 class="label">Incident Information</h3>
	</div>
	</div>
	</div>
	</div>
	<!------------Incident Info--------------->

	<?php
		if(isset($_GET['viewMore'])!= 'true'){ //if this page is not a result of clicking on view more in approve incident list page
			header("Location: agency_view_incident_list.php");
			exit();
		}

		$agencyController = new agencyController();
		$incidentId = $_GET['incidentId'];
		$result = $agencyController->getSpecificIncident($incidentId);

		$result1 = $agencyController->getSpecificDispatchDetails($incidentId);

		//Error Messages for DB
		if($result == 'viewSentRequestError'){
			echo '<p class="viewSentRequestError" style="color:red">Database execution error. Please try again later</p>';
		}
		else if($result == 'sqlError'){
			echo '<p class="sqlError" style="color:red">Database connection error. Please try again later</p>';
		}
	?>

	<div class = "main-content">
	<div class="col-md-8">	
		<table class="table table-borderless">
			<tr>
				<td>
					<label for="incidentId" class="boldLbl">Incident ID:</label>
				</td>
				<td>
					<?php echo($incidentId); ?>
					<input type="hidden" id="incidentId" name="incidentId"></input><!---input type so that can be passed to server. label cannot be read by server--->
				</td>
			</tr>
			<tr>
				<td>
					<label for="name" class="boldLbl">Name:</label>
				</td>
				<td>
					<?php echo($result->getName()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="mobileNo" class="boldLbl">Mobile No.:</label>
				</td>
				<td>
					<?php echo($result->getMobileNo()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="location" class="boldLbl">Location:</label>
				</td>
				<td>
					<?php echo($result->getLocation()); ?>
				</td>
			</tr>
			<?php
				if($result->getUnitNo() != "" && $result->getUnitNo() != "-"){
			?>
					<tr>
						<td>
							<label class="boldLbl">Unit Number:</label>
						</td>
						<td>
							<?php echo($result->getUnitNo()); ?>
						</td>
					</tr>
			<?php		
				}
			?>
			<tr>
				<td>
					<label for="emergencyType" class="boldLbl">Type of Emergency:</label>
				</td>
				<td>
					<?php echo($result->getEmergencyType()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="assistanceType" class="boldLbl">Type of Assistance:</label>
				</td>
				<td>
					<?php echo($result->getTypeOfAssistance()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="remarks" class="boldLbl">Remarks:</label>
				</td>
				<td>
					<?php echo($result->getRemarks()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="dateTime" class="boldLbl">File Date Time:</label>
				</td>
				<td>
					<?php echo($result->getFileDateTime()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="dispatchUnits" class="boldLbl">Dispatch Units:</label>
				</td>
				<td>
					<?php echo($result1->getDispatchUnits()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<a href="agency_view_incident_list.php" class="btn btn-basic">Back</a>
				</td>
				<td>
					<!-- Button trigger modal -->
					<?php
						$checkMsgRecordResult= $agencyController->getAllMsg($incidentId); 
						//returns all messages of a specific incident.
						if($checkMsgRecordResult!= false){
					?>
							<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">View Previous Updates</button>
					<?php
						}
						$checkStatusRecord = $agencyController->getStatus($incidentId); 
						//returns statuss obj if exists else returns false
						if($checkStatusRecord != true ){ //i.e.: the status is "Resolved"
					?>
							<a href="agency_update_incident_status.php?update=true&incidentId=<?php echo($incidentId)?>" class="btn btn-primary" >Update</a>
					<?php
						}
					?>
				</td>
			</tr>
		</table>
	</div>
	</div>


	<!------------Modal--------------->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<?php
    	if($checkMsgRecordResult!= false){
    ?>
  	<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    	<div class="modal-header">
        	<h5 class="modal-title" id="exampleModalLabel">Previous Updates</h5>
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        	</button>
      	</div>
      	<div class="modal-body">
        	<table>
        		<?php
        			foreach($checkMsgRecordResult as $row ){
        		?>
        				<tr>
							<td><b><?php echo ($row['updateDateTime']); echo(":&nbsp;"); ?></b></td>
							<?php 
								if($row['msg'] == ''){
							?>
									<td><?php echo("-"); ?></td>
							<?php
								}
								else{
							?>
									<td><?php echo ($row['msg']); ?></td>
							<?php
								}
							?>
						</tr>
						<tr>
							<?php
								if($row['updateStatus'] == 'Resolved'){
							?>
									<td><i>Number of Deaths:</i></td>
									<td><?php echo($row['numDeaths']); ?></td>
						</tr>
						<tr>
									<td><i>Number of Injured:</i></td>
									<td><?php echo($row['numInjured']); ?></td>
							<?php
								}
							?>
						</tr>
				<?php
					}
				?>
        	</table>
      	</div>
     	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      	</div>
    </div>
    <?php
    	}
    ?>
 	</div>
	</div>

	
	<!----------Footer----------->
	<div class = "main-content">
		<?php include('../includes/footer.php');?>
	</div>
	
</body>
</html>

<!---------------Client-side Validation----------------->
<script>
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

//fill in label with values based on querystring passed
function fillFunction(){
	//incidentId
	var incidentId = document.getElementById('incidentId');
	incidentId.value = getParameterByName('incidentId');
}
</script>