<?php
 
/*
 * Following code will list all the product
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
$json_results = json_decode($_GET["json"]);
if($json_results->clinicID){
	// get all clinics from clinic table
	$clinicID = $json_results->clinicID;
	
	$result = mysql_query("SELECT * FROM comments WHERE clinicID = $clinicID") or die(mysql_error());

	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// product node
		$response["comments"] = array();
	 
		while ($row = mysql_fetch_array($result)) {
			// temp user array
				$comments = array();
				$comments["commentsID"] = $row["commentsID"];
				$comments["clinicID"] = $row["clinicID"];
				$comments["patientID"] = $row["patientID"];
				$comments["comment"] = $row["comment"];
				$comments["commentsDate"] = $row["commentsDate"];
				
				$patientID = $row["patientID"];
				$resultPatient = mysql_query("SELECT * FROM patient WHERE patientID = $patientID") or die(mysql_error());
				$rows = mysql_fetch_array($resultPatient);

				$comments["firstName"] = $rows["firstName"];
				$comments["lastName"] = $rows["lastName"];
			   
	 
			// push single clinic into final response array
			array_push($response["comments"], $comments);
		}
		// success
		$response["success"] = 1;
	 
		// echoing JSON response
		echo json_encode($response);
	} else {
		// no product found
		$response["success"] = 0;
		$response["message"] = "No booking found";
	 
		// echo no users JSON
		echo json_encode($response);
	}
}else{
	// no product found
		$response["success"] = 0;
		$response["message"] = "Clinic not specified";
	 
		// echo no users JSON
		echo json_encode($response);
}
?>