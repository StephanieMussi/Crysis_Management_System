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

	<?php
		//when pmo click reject on the view more page
		if(isset($_GET['reject']) != true){
			if(isset($_GET['edit']) != true){
				header("Location: pmo_view_more_info.php");
				exit();
			}
		}
	?>

	<!----------------Approve incident list-------------->
	<div class = "main-content">
	<div class="container">
	<div class="col-md-12">
	<div class="row">
		<h3 class="label">Reject Suggestion On Action</h3>
	</div>
	</div>
	</div>
	</div>
	<!------------Incident Info--------------->

	<?php

		$incidentController = new pmoController();
		//$incidentController->setAccessToken("pmo");
		$incidentId = $_GET['incidentId'];
		$result = $incidentController->getSpecificIncident($incidentId);

		//$severeCaseController = new severeIncidentController();
		//$severeCaseController->setAccessToken("pmo");
		$result1 = $incidentController->getSpecificSevereCase($incidentId);

		if($result == 'viewSentRequestError'){
			echo '<div class="alert alert-danger" role="alert">
 	 				Database execution error. Please try again later
				</div>';
		}
		else if($result == 'sqlError'){
			echo '<div class="alert alert-danger" role="alert">
 	 				Database connection error. Please try again later
				</div>';
		}
	?>


	<!-------------------------re-display all the informations to the pmo---------------------------------->
	<div class = "main-content">
	<div class="col-md-8">	
		<form name="form" action="pmo_confirm_reject.php" method="POST" onsubmit="return validateProposal()">
		<table class="table table-borderless" >
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
			<!---------------------------------------suggestion area----------------------------------------->
			<!-----------------------------suggestion form textarea--------------------------------->
			<tr>
				<td>
					<label class="boldLbl">Proposed Suggestion</label>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<textarea type="text" class="form-control col-12" id="ProposedSuggestion" placeholder="" name="ProposedSuggestion" onchange="verifySuggestion()"></textarea>
					<input type="hidden" id="incidentId" name="incidentId" value=<?php echo $incidentId?> >
					<input type="hidden" id="rejectReason" name="rejectReason" value="true" >
				</td>
			

			</tr>
			<tr>
				<td colspan=2>
					<div id="proposal_error" class="errorMsg"></div>
				</td>
			</tr>

			<tr>
				<td>
					<button type="button" class="btn btn-light" onclick="back()">Back</button>
				</td>
				<td>
					<button type="submit" name="btn_submit" class="btn btn-primary rightmost">Submit</button>
				</td>
			</tr>
			</form>
		</table>
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

	if(getParameterByName('edit') == "true"){
		var proposal = document.getElementById('ProposedSuggestion');
		proposal.textContent = getParameterByName('proposedSuggestion');
	}
}

function verifySuggestion(){
	var proposal = document.getElementById('ProposedSuggestion');
	var proposal_error = document.getElementById('proposal_error');
	if(proposal.value != ""){
		ProposedSuggestion.blur();
		proposal_error.innerHTML = "";
		return true;
	}
}

function validateProposal(){
	var proposal = document.getElementById('ProposedSuggestion');
	var proposal_error = document.getElementById('proposal_error');
	if(proposal.value == ""){
		proposal_error.textContent = "Please enter a suggestion";
		proposal.focus();
		proposal.select();
		return false;
	}
	return true;
}

function back(){
	url = "pmo_view_more_info.php?viewMore=true&incidentId=<?php echo $incidentId?>"
	window.location.assign(url);
}

</script>
