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
$result = mysql_query("SELECT * FROM patient") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // product node
    $response["patient"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
            $patient = array();
            $patient["patientID"] = $row["patientID"];
            $patient["firstName"] = $row["firstName"];
			$patient["middleName"] = $row["middleName"];
			$patient["lastName"] = $row["lastName"];
            $patient["address"] = $row["address"];
            $patient["phoneNumber"] = $row["phoneNumber"];
            $patient["email"] = $row["email"];
            $patient["password"] = $row["password"];
 
        // push single clinic into final response array
        array_push($response["patient"], $patient);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No patient found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>