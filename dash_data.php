<?php

/*
 * Following code will get single user details
 * A user is userIDentified by user userID (puserID)
 */

// array for JSON response
$response = array();
// check for require fields
// include db connect class

require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/model/Patient.php';

// connecting to db
$db = new DB_CONNECT();
$json_results = json_decode($_GET["json"]);
// check for post data
if ($json_results->patientID ) {
    //$email = $json_results->email;
    $patientID = $json_results->patientID;

            // get a user from user table
           
			$response["booking"] = array();


            
            $results = mysql_query("SELECT * FROM booking WHERE patientID = '$patientID' ORDER BY bookingDate");

            while ($rows = mysql_fetch_array($results)) {
                $booking = array();
                $booking["bookingID"] = $rows["bookingID"];
                $booking["patientID"] = $rows["patientID"];
                $booking["bookingDate"] = $rows["bookingDate"];
                $booking["dateAttended"] = $rows["dateAttended"];
                $booking["refNumber"] = $rows["refNumber"];
                $booking["flag"] = $rows["flag"];
				$booking["timeSlotID"] = $rows["timeSlotID"];
				
				$timeSlotID = $rows["timeSlotID"];
				$resultSlot = mysql_query("SELECT * FROM timeSlot WHERE timeSlotID = '$timeSlotID'");
				$rowSlot = mysql_fetch_array($resultSlot);	
				$booking["slots"]= $rowSlot["slots"];
	

                $clinicID = $rows["clinicID"];
                $resultClinic = mysql_query("SELECT * FROM clinic WHERE clinicID = '$clinicID'");
                $rowsClinic = mysql_fetch_array($resultClinic);
                $clinic = array();
                $clinic["clinicID"] = $rowsClinic["clinicID"];
                $clinic["townID"] = $rowsClinic["townID"];
                $clinic["name"] = $rowsClinic["name"];
                $clinic["phoneNumber"] = $rowsClinic["phoneNumber"];
                $clinic["email"] = $rowsClinic["email"];
                $clinic["password"] = $rowsClinic["password"];
                $clinic["longitude"] = $rowsClinic["longitude"];
                $clinic["latitude"] = $rowsClinic["latitude"];

                //getting town
                $townID = $clinic["townID"];
                $resultsTown = mysql_query("SELECT * FROM town WHERE townID = $townID");

                $row = mysql_fetch_array($resultsTown);

                $clinic["provinceID"] = $row["provinceID"];
                $clinic["townName"] = $row["name"];
                $clinic["longitudeTown"] = $row["longitude"];
                $clinic["latitudeTown"] = $row["latitude"];



                // push category into final response array
                //echo $booking["dateAttended"];
                $booking["clinic"] = array();
                array_push($booking["clinic"], $clinic);
                // push category into final response array
                //echo $booking["dateAttended"];
				// patient
            array_push($response["booking"], $booking);
            }

            //getting town
            $response["town"] = array();
            $resultsTown = mysql_query("SELECT * FROM town");

            while ($row = mysql_fetch_array($resultsTown)) {
                $town = array();
                $town["townID"] = $row["townID"];
                $town["provinceID"] = $row["provinceID"];
                $town["name"] = $row["name"];
                $town["longitude"] = $row["longitude"];
                $town["latitude"] = $row["latitude"];


                // push category into final response array
                //echo $booking["dateAttended"];
                array_push($response["town"], $town);
            }

            // success
            $response["success"] = 1;
            $response["message"] = "patient successfully sign up";
            // users node
            


            // echoing JSON response
            echo json_encode($response);
       
    
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>