<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
//echo json_encode($order_date);//selecting the inserted values back
// check for require fields
$json_results = json_decode($_GET["json"]);

$booking = $json_results->booking;
//echo json_encode($booking);
if ($booking->clinicID && $booking->patientID && $booking->timeSlotID) {

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    $clinicID = $booking->clinicID;
    $patientID = $booking->patientID;
    $bookingDate = date('Y-m-d H:i:s');
    $dateAttended = date('Y-m-d H:i:s');
    $refNumber = randomPassword();
    $flag = 1;
	$timeSlotID = $booking->timeSlotID;

    //if successfully selected the values
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO booking(clinicID,patientID,bookingDate,dateAttended,refNumber,flag,timeSlotID) 
	   VALUES('$clinicID','$patientID','$bookingDate', '$dateAttended','$refNumber','1','$timeSlotID')");
    echo mysql_error();

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "booking successfully made.";

        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.dfs";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missingfd";

    // echoing JSON response
    echo json_encode($response);
}
?>