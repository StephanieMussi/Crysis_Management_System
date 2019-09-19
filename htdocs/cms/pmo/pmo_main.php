<html>
<head>
	<!----------Header----------->
	<?php include('pmo_header.php');?>
	<?php include('../classes/pmoController.php');?>

</head>
<body>
	<!---------------------Navigation bar------------------------->
	<!----------Top Navigation Bar-------->
	<?php include('pmo_top_nav_bar.php');?>

	<!----------Side Navigation Bar-------->
	<?php include('../script/side_nav_bar.php');?>

	<!------------------Dashboard section------------------>
	<section>	
		<div class = "main-content">
		<div class="container">
		<div class="row">
		<div class="col-md-12">
			<h3 class="label">Dashboard</h3>
		<br/>
	

        
	<!------------------(1)Charts section - SUMMARY OF SEVERE INCIDENTS------------------>

		<!------------------(a)Array of Datapoints Section------------------>
	<?php
		$pmoController = new pmoController();
		
		
		$dataPoints = array(
			array("label"=> "Fire", "y"=> $pmoController->getNumberOfFire()),
			array("label"=> "Gas Leak", "y"=> $pmoController->getNumberOfGasLeak()),
			array("label"=> "Terrorist Attack", "y"=> $pmoController->getNumberOfTerroristAttack()),
			array("label"=> "Traffic Accident", "y"=> $pmoController->getNumberOfTrafficAccident()),
			array("label"=> "Natural Disaster", "y"=> $pmoController->getNumberOfNaturalDisaster()),
			array("label"=> "Others", "y"=> $pmoController->getNumberOfOthers()),
		);	
	?>
	
	<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br/>
		<br/>
	
	<!------------------(2)Charts section - SUMMARY OF SEVERE INCIDENTS PER MONTH------------------>
		<?php

		/*------------------(a)Array of Datapoints Section------------------*/

		/*------------------(ai)Number of INCIDENTS----------------------------*/
		$dataPoints1 = array(
		array("label"=> "Jan", "y"=> $pmoController -> getNumberOfIncident("January")),
		array("label"=> "Feb", "y"=> $pmoController -> getNumberOfIncident("February")),
		array("label"=> "Mar", "y"=> $pmoController -> getNumberOfIncident("March")),
		array("label"=> "Apr", "y"=> $pmoController -> getNumberOfIncident("April")),
		array("label"=> "May", "y"=> $pmoController -> getNumberOfIncident("May")),
		array("label"=> "Jun", "y"=> $pmoController -> getNumberOfIncident("June")),
		array("label"=> "Jul", "y"=> $pmoController -> getNumberOfIncident("July")),
		array("label"=> "Aug", "y"=> $pmoController -> getNumberOfIncident("August")),
		array("label"=> "Sep", "y"=> $pmoController -> getNumberOfIncident("September")),
		array("label"=> "Oct", "y"=> $pmoController -> getNumberOfIncident("October")),
		array("label"=> "Nov", "y"=> $pmoController -> getNumberOfIncident("November")),
		array("label"=> "Dec", "y"=> $pmoController -> getNumberOfIncident("December")),
		);

		

		?>
		<div id="incidentChartContainer" style="height: 370px; width: 100%;"></div>
		<br/>
		</div>
		</div>
		</div>
	</section>
	




	
	<!----------Footer----------->
	<div class = "main-content">
		<?php include('../includes/footer.php');?>
	</div>
	
	<!----------chart function----------->
		<script>
		window.onload = function () {
 		startTime();
		var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
		text: "Summary of Severe Incidents Occured"
		},
		axisY: {
		title: "Number of Incidents",
		includeZero: false
		},
		data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}]
		});
		chart.render();

		var incidentchart = new CanvasJS.Chart("incidentChartContainer", {
		animationEnabled: true,
		theme: "light2",
		title:{
		text: "Summary of Severe Incidents for Every Month"
		},
		legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
		},
		data: [{
		type: "column",
		name: "Number of Incidents",
		indexLabel: "{y}",
		yValueFormatString: "0",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		}]
		});
		incidentchart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	incidentchart.render();
	}
 
   }
	
</script>
</body>
</html>