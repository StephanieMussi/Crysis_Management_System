<?php
	require "vendor/autoload.php";
	include('../classes/cmoController.php');

	use Abraham\TwitterOAuth\TwitterOAuth;
 
	define('CONSUMER_KEY', 'KyGfC0ocuSg4ofYwVmNLPZhgd');
	define('CONSUMER_SECRET', '4tgHCJGdv9cQeTUeBqcU9HHAL79T3TYBdpslgb43tuEsHHp1iN');
	define('ACCESS_TOKEN', '1109003141230395393-ZMzMJZGDH8yGOabkvazyqSZRea92mi');
	define('ACCESS_TOKEN_SECRET', 'wGtTSkCXlemoqlFB6aGhluFRIeEYsZ6zb2xsHxnzn8A89');
 
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
 
	$status = $_POST["infoInput"]; //text for tweet.
	$post_tweets = $connection->post("statuses/update", ["status" => $status]);


	$incidentId = $_POST['incidentId'];
	$emergencyType = $_POST['emergencyType'];
	$location = $_POST['location'];
	

	//insert into publish db
	$publish = new publish();
	$publish->setIncidentId($incidentId);
	$publish->setMsg($status);
	$publish->setType('twitter');

	session_start();
	$cmo_username = $_SESSION['username'];
	$publish->setCmoUsername($cmo_username);

	$cmoController = new cmoController();

	$cmoController->insertPublishDetails($publish);

	$incidentId = $_POST['incidentId'];
	$emergencyType = $_POST['emergencyType'];
	$location = $_POST['location'];
	header("Location: ../cmo/cmo_confirm_publish_incident.php?incidentId=".$incidentId."&emergencyType=".$emergencyType."&location=".$location);

?>