<?php


//include('../classes/incident.php');
include('../classes/cmoController.php');

$incidentController = new cmoController();
$result = $incidentController->getNotifyNewIncident();

if(sizeof($result)>0)
{
    echo json_encode($result);
}else{
    echo "NIL";
}

?>