<?php
	include_once('../classes/cmoController.php');
	include_once('../classes/agencyController.php');

	//dispatch means this incident will appear in agency's incident table and location table and dispatchDetails table

	if(isset($_POST['btn_submit'])){ //if this page is a result of clicking the submit button
		
		$incidentId = $_POST['incidentId'];
		$cmoController = new cmoController();
		$incidentObj = $cmoController->getSpecificIncident($incidentId);

		$name = $incidentObj->getName();
		$mobileNo = $incidentObj->getMobileNo();
		$location = $incidentObj->getLocation();
		/*
		$locationlist = explode(" ", $location);
		$location2 = "";
		for($i=0;$i<=count($locationlist);$i++){

            $location2 .= $locationlist[$i] . '+';

        }
        */


		$location2 = preg_replace('/\h+/', "%2B", $location);
		$unitNo = $incidentObj->getUnitNo();
		
		$emergencyType = $_POST['emergencyType'];
		$assistanceType = $_POST['assistanceType'];
		$remarks = $_POST['remarks'];
		
		$fileDateTime = $incidentObj->getFileDateTime();
		$filedBy = $incidentObj->getCcoUsername();

		session_start();
		$cmo_username = $_SESSION['username'];
		
		$scdf = $_POST['scdf'];
		$spf = $_POST['spf'];
		$sof = $_POST['sof'];
		$_995 = $_POST['995'];
		$sp = $_POST['sp'];

		$dispatchUnit = "";
		$i = 0;
		if($scdf == 'checked'){
			$dispatchUnit .= "SCDF";
			$i++;
		}
		if($spf == 'checked'){
			if($i > 0){
				$dispatchUnit .= ", SPF";
			}
			else{
				$dispatchUnit .= "SPF";
			}
			$i++;
		}
		if($sof == 'checked'){
			if($i > 0){
				$dispatchUnit .= ", SOF";
			}
			else{
				$dispatchUnit .= "SOF";
			}
			$i++;
		}
		if($_995 == 'checked'){
			if($i > 0){
				$dispatchUnit .= ", 995";
			}
			else{
				$dispatchUnit .= "995";
			}
			$i++;
		}
		if($sp == 'checked'){
			if($i > 0){
				$dispatchUnit .= ", Singapore Power";
			}
			else{
				$dispatchUnit .= "Singapore Power";
			}
			$i++;
		}



		//echo($unitNo);
		$firstCharacter = substr($unitNo, 0, 1);
		if($firstCharacter == "#"){
			$newUnitNo = substr($unitNo, 1);
		}
		else{
			$newUnitNo = $unitNo;
		}


		//echo($newUnitNo);
		//$botToken = "886234058:AAGpO0Xd6oy81EMGZFjsWjB-F-3HzOegtk4";

        $botToken = "851575110:AAEciKHATEmB2G9lGAv191Wy64Ut7EDTedc";
        //$botToken = "705846600:AAGC0CmID2b-jRmEQfrCS8QSLTRf_WgJrwA"; //shuen's
        $website = "https://api.telegram.org/bot".$botToken;
		$update = file_get_contents($website."/getupdates");
	
		$updateArray = json_decode($update, TRUE);
	
		//$chatId = $updateArray["result"][0]["message"]["chat"]["id"];
	    //$chatId = 259158992;
        $chatId = -399629657; //This is testing group ID so dont spam me pls
        //$chatId = 741132479; //shuen's
        //agency_view_incident_details.php?viewMore=true&incidentId=
        //$finalincidenturl = "/cms/agency/agency_view_incident_details.php?viewMore=true&incidentId=".$incidentId;
        $finalincidenturl = "10.27.248.222:8080/htdocs/cms/agency/agency\_view\_incident\_details.php?viewMore=true%26incidentId=".$incidentId;
        //$finalincidenturl = preg_replace('_', "%5F", $incidenturl);

        if($unitNo != '-'){
        	$text = "!!!Emergency!!!%0AIncident ID: " . $incidentId  . "%0AIncident Type: "  .  $emergencyType   . "%0ADate and Time: ".   $fileDateTime   . "%0ALocation: ". $location . "%0AUnit No: %23". $newUnitNo . "%0ADispatch Units: *" . $dispatchUnit ."*%0AWitness: " . $name . "%0AWitness's Mobile No.: " . $mobileNo . "%0ARemarks: " . $remarks ."%0AResponse URL : ".$finalincidenturl . "%0ADirections: https://www.google.com/maps?daddr=" . $location2;
        }
        else{
        	$text = "!!!Emergency!!!%0AIncident ID: " . $incidentId  . "%0AIncident Type: "  .  $emergencyType   . "%0ADate and Time: ".   $fileDateTime   . "%0ALocation: ". $location . "%0ADispatch Units: " . $dispatchUnit ."%0AWitness: " . $name . "%0AWitness's Mobile No.: " . $mobileNo . "%0ARemarks: " . $remarks ."%0AResponse URL : ". $finalincidenturl . "%0ADirections: https://www.google.com/maps?daddr=" . $location2;
        }
        
		//file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$text."&parse_mode=Markdown");
        file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$text."&parse_mode=Markdown");
		// add url to send for agency to click and go to login page


		//initialize dispatchMsg to store in db
		//$dispatchMsg = "incidentId=".$incidentId."&mobileNo=".$mobileNo."&location=".$location."&unitNo=".$unitNo."&emergencyType=".$emergencyType."&assistanceType=".$assistanceType."&remarks=".$remarks."&fileDateTime=".$fileDateTime."&filedBy=".$filedBy."dispatchUnit=".$dispatchUnit;

		//insert into db
		$cmo_dispatch = new dispatch();
		$cmo_dispatch->setCmoUsername($cmo_username);
		$cmo_dispatch->setIncidentId($incidentId);
		$cmo_dispatch->setDispatchUnits($dispatchUnit);

		$result = $cmoController->insertDispatchDetails($cmo_dispatch); //pass dispatch obj
		if($result == 'success'){
			//once insert at cmo dispatch table successfully, do the insertion at agency table
			//1st, insert into agency incident table
			$agencyController = new agencyController();
			$incidentObj->setTypeOfAssistance($assistanceType);
			$incidentObj->setEmergencyType($emergencyType);
			$incidentObj->setRemarks($remarks);
			$agencyController->insertDetails($incidentObj); //pass incident obj

			//2nd, insert into agency location table
			$locationObj = $cmoController->getSpecificIncidentLatLng($incidentId);
			$agencyController->insertLatLngDetails($locationObj); //pass location obj

			//3rd, insert into agency dispatch table
			$agencyController->insertDispatchDetails($cmo_dispatch); //pass dispatch obj
			
			header("Location:../cmo/cmo_view_incident_list.php?result=dispatchSuccess");	
			exit();
		}
	}
	else{
		header("Location: cmo_send_sms_view_all.php");
		exit();
	}
?>