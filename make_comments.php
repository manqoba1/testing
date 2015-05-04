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

$comments = $json_results->comments;
//echo json_encode($booking);
if ($comments->clinicID && $comments->patientID && $comments->comment) {

    $clinicID = $booking->clinicID;
    $patientID = $booking->patientID;
    $comment = $comments->comment;
    $commentsDate = date('Y-m-d H:i:s');

    //if successfully selected the values
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO comments(comment,commentsDate,clinicID,patientID) 
	   VALUES('$comment','$commentsDate','$clinicID', '$patientID')");
    echo mysql_error();

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "comment received.";

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