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
if ($json_results->email && $json_results->password) {
    //$email = $json_results->email;
    $password = $json_results->password;
    $email = $json_results->email;



    // get a patient from user table
    $result = mysql_query("SELECT * FROM patient WHERE email = '$email' && password = '$password'");

    if (!empty($result)) {
        // check for empty result

        if (mysql_num_rows($result) > 0) {


            $row = mysql_fetch_array($result);

            $patient = array();
            $patient["patientID"] = $row["patientID"];
            $patient["firstName"] = $row["firstName"];
            $patient["middleName"] = $row["middleName"];
            $patient["lastName"] = $row["lastName"];
            $patient["phoneNumber"] = $row["phoneNumber"];
            $patient["email"] = $row["email"];
            $patient["password"] = $row["password"];

            $patientID = $row["patientID"];
           
            // success
            $response["success"] = 1;
            $response["message"] = "patient successfully sign up";
            // users node
            $response["patient"] = array();


            // patient
            array_push($response["patient"], $patient);


            // echoing JSON response
            echo json_encode($response);
        } else {
            // no user found
            $response["success"] = 0;
            $response["message"] = "Incorrect Email or Password.";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no user found
        $response["success"] = 0;
        $response["message"] = "Incorrect Email or Password.";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>