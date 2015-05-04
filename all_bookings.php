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
 
// get all clinics from clinic table
$result = mysql_query("SELECT * FROM booking") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // product node
    $response["booking"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
            $booking = array();
            $booking["bookingID"] = $row["bookingID"];
            $booking["clinicID"] = $row["clinicID"];
			$booking["patientID"] = $row["patientID"];
			$booking["bookingDate"] = $row["bookingDate"];
            $booking["dateAttended"] = $row["dateAttended"];
            $booking["refNumber"] = $row["refNumber"];
            $booking["flag"] = $row["flag"];
           
 
        // push single clinic into final response array
        array_push($response["booking"], $booking);
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
?>