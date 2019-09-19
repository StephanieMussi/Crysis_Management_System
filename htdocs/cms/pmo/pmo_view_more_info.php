<html>
<head>
	<?php include('../classes/pmoController.php'); ?>
    <!----------Header----------->
	<?php include('pmo_header.php');?>
</head>
<body onload="fillFunction()">
	<!----------Top Navigation Bar-------->
	<?php include('pmo_top_nav_bar.php');?>

	<!----------Side Navigation Bar-------->
	<?php include('../script/side_nav_bar.php');?>

	<!----------------Approve incident list-------------->
	<div class = "main-content">
	<div class="container">
	<div class="col-md-12">
	<div class="row">
		<h3 class="label">Incident Awaiting for Approval</h3>
	</div>
	</div>
	</div>
	</div>
	<!------------Incident Info--------------->

	<?php
		if(isset($_GET['viewMore'])!= 'true'){ //if this page is not a result of clicking on view more in approve incident list page
			header("Location: pmo_approve_incident_list.php");
			exit();
		}
		else{
			if($_GET['viewMore'] != "true"){
				header("Location: pmo_approve_incident_list.php");
				exit();
			}
		}

		if(isset($_GET['error'])){
			if($_GET['error'] == "insertError"){
				echo '<div class="alert alert-danger" role="alert">
 	 						Database execution error. Please try again later
						</div>';
			}
			else if($_GET['error'] == "sqlError"){
				echo '<div class="alert alert-danger" role="alert">
 	 						Database connection error. Please try again later
						</div>';
			}
		}

		$incidentController = new pmoController();
		//$incidentController->setAccessToken("pmo");
		$incidentId = $_GET['incidentId'];
		$result = $incidentController->getSpecificIncident($incidentId);

		//$severeCaseController = new severeIncidentController();
		//$severeCaseController->setAccessToken("pmo");
		$result1 = $incidentController->getSpecificSevereCase($incidentId);

		if($result == 'viewSentRequestError'){
			echo '<p class="viewSentRequestError" style="color:red">Database execution error. Please try again later</p>';
		}
		else if($result == 'sqlError'){
			echo '<p class="sqlError" style="color:red">Database connection error. Please try again later</p>';
		}
	?>

	<div class = "main-content">
	<div class="col-md-10">	
		<table class="table table-borderless">
			<col class="wide">
			<tr>
				<td>
					<label for="incidentId" class="boldlbl">Incident ID:</label>
				</td>
				<td>
					<?php echo($incidentId); ?>
					<input type="hidden" id="incidentId" name="incidentId"></input><!---input type so that can be passed to server. label cannot be read by server--->
				</td>
			</tr>
			<tr>
				<td>
					<label for="name" class="boldlbl">Name:</label>
				</td>
				<td>
					<?php echo($result->getName()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="mobileNo" class="boldlbl">Mobile No.:</label>
				</td>
				<td>
					<?php echo($result->getMobileNo()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="location" class="boldlbl">Location:</label>
				</td>
				<td>
					<?php echo($result->getLocation()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="emergencyType" class="boldlbl">Type of Emergency:</label>
				</td>
				<td>
					<?php echo($result->getEmergencyType()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="assistanceType" class="boldlbl">Type of Assistance:</label>
				</td>
				<td>
					<?php echo($result->getTypeOfAssistance()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="remarks" class="boldlbl">Remarks:</label>
				</td>
				<td>
					<?php echo($result->getRemarks()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="dateTime" class="boldlbl">File Date Time:</label>
				</td>
				<td>
					<?php echo($result->getFileDateTime()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="filedBy" class="boldlbl">Filed By:</label>
				</td>
				<td>
					<?php 
						if($result->getCcoUsername() == ""){
							echo "Public";
						}
						else{
							echo ($result->getCcoUsername());
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="severityLevel" class="boldlbl">Severity Level:</label>
				</td>
				<td>
					<?php echo($result1->getSeverityLevel()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="suggestion" class="boldlbl">Suggestion on Action:</label>
				</td>
				<td>
					<?php echo($result1->getSuggestionOnAction()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="requestSentBy" class="boldlbl">Request Sent By:</label>
				</td>
				<td>
					<?php echo($result1->getCmoUsername()); ?>
				</td>
			</tr>
			<tr>
				<td>
					<a href="pmo_approve_incident_list.php" class="btn btn-basic">Back</a>
				</td>
				<td>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Accept</button>
					<a href="pmo_reject.php?reject=true&incidentId=<?php echo $incidentId?>" class="btn btn-danger">Reject</a>
				</td>
			</tr>
		</table>
	</div>
	</div>


	<!------------Modal--------------->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    	<div class="modal-header">
        	<h5 class="modal-title" id="exampleModalLabel">Accept Confirmation</h5>
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        	</button>
      	</div>
      	<div class="modal-body">
        	<center>
        		Are you sure you would like to accept the suggestion?<br/>
        		This process cannot be undone.
      		</center>
      	</div>
     	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        	<button type="button" class="btn btn-primary" onclick="clickConfirm(<?php echo($incidentId); ?>)">Confirm</button>
      	</div>
   	</div>
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
    var regex = new RegExp('[?&]' + name + '(=([^&]*)|&|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

//fill in label with values based on querystring passed
function fillFunction(){
	//incidentId
    startTime();
	var incidentId = document.getElementById('incidentId');
	incidentId.value = getParameterByName('incidentId');
}

//if user click on confirm button
function clickConfirm(incidentId){
	url = "../script/pmo_accept_suggestion.php?confirmAccept=true&incidentId="+incidentId;
	window.location.assign(url);
}
</script>