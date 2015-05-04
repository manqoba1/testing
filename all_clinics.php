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
$result = mysql_query("SELECT * FROM clinic") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // product node
    $response["Clinic"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
            $clinic = array();
            $clinic["clinicID"] = $row["clinicID"];
            $clinic["townID"] = $row["townID"];
			$clinic["name"] = $row["name"];
			$clinic["phoneNumber"] = $row["phoneNumber"];
            $clinic["email"] = $row["email"];
            $clinic["password"] = $row["password"];
            $clinic["longitude"] = $row["longitude"];
            $clinic["latitude"] = $row["latitude"];
 
        // push single clinic into final response array
        array_push($response["Clinic"], $clinic);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No client found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>