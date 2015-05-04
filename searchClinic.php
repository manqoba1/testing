<?php
$response = array();
 // check for require fields

// include db connect class
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/model/Patient.php';

// connecting to db
$db = new DB_CONNECT();
 $json_results = json_decode($_GET["json"]);
 if($json_results->townID){
			//getting clinics
	$townID = $json_results->townID;
	$response["clinic"] = array();
	$resultsClinic = mysql_query("SELECT * FROM clinic WHERE townID = $townID");
			
	while($rowsClinic = mysql_fetch_array($resultsClinic)){
		$clinic = array();
		$clinic["clinicID"] = $rowsClinic["clinicID"];
		$clinic["townID"] = $rowsClinic["townID"];
		$clinic["name"] = $rowsClinic["name"];
		$clinic["phoneNumber"] = $rowsClinic["phoneNumber"];
		$clinic["email"] = $rowsClinic["email"];
		$clinic["password"] = $rowsClinic["password"];
		$clinic["longitude"] = $rowsClinic["longitude"];
		$clinic["latitude"] = $rowsClinic["latitude"];				
				
 
		// push category into final response array
		//echo $booking["dateAttended"];
		array_push($response["clinic"], $clinic);
	}
	 // success
    $response["success"] = 1;
	$response["message"] = "clinic data found";
   			
 
    // echoing JSON response
    echo json_encode($response);
 }
?>