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
$result = mysql_query("SELECT * FROM staff") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // product node
    $response["staff"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
            $staff = array();
            $staff["staffID"] = $row["staffID"];
            $staff["clinicID"] = $row["clinicID"];
			$staff["firstName"] = $row["firstName"];
			$staff["middleName"] = $row["middleName"];
            $staff["lastName"] = $row["lastName"];
            $staff["phoneNumber"] = $row["phoneNumber"];
            $staff["email"] = $row["email"];
            $staff["password"] = $row["password"];
 
        // push single clinic into final response array
        array_push($response["staff"], $staff);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No staff found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>