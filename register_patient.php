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
// check for require fields
$json_results = json_decode($_GET["json"]);


if ($json_results->firstName && $json_results->middleName && $json_results->lastName && $json_results->phoneNumber && $json_results->email && $json_results->password) {

    $firstName = $json_results->firstName;
    $middleName = $json_results->middleName;
    $lastName = $json_results->lastName;
    $phoneNumber = $json_results->phoneNumber;
    $email = $json_results->email;
    $password = $json_results->password;


//Let's check if the user is already registered
    $checkemail = mysql_query("select * from patient where email='$email' ");
    if (mysql_num_rows($checkemail) > 0) {

        echo mysql_num_rows($checkemail);

        $response["message"] = "The email address has been registered already";

        // echoing JSON response
        echo json_encode($response);
    } else {


        // mysql inserting a new row
        $result = mysql_query("INSERT INTO patient(firstName,middleName,lastName,phoneNumber,email,password) 
	                   VALUES('$firstName','$middleName', '$lastName','$phoneNumber','$email','$password')");
        echo mysql_error();


        // check if row inserted or not
        if ($result) {

            $response["success"] = 1;
            $response["message"] = "Registration successful, Please Check Your Email.";
            $result_pa = mysql_query("SELECT * FROM patient WHERE phoneNumber = '$phoneNumber'");

            if (!empty($result_pa)) {
                // check for empty result

                if (mysql_num_rows($result_pa) > 0) {


                    $row = mysql_fetch_array($result_pa);

                    $patient = array();
                    $patient["patientID"] = $row["patientID"];
                    $patient["firstName"] = $row["firstName"];
                    $patient["middleName"] = $row["middleName"];
                    $patient["lastName"] = $row["lastName"];
                    $patient["phoneNumber"] = $row["phoneNumber"];
                    $patient["email"] = $row["email"];
                    $patient["password"] = $row["password"];

                    $patientID = $row["patientID"];
                    // get a user from user table
                    $patient["booking"] = array();
                    $results = mysql_query("SELECT * FROM booking WHERE patientID = '$patientID'");

                    while ($rows = mysql_fetch_array($results)) {
                        $booking = array();
                        $booking["bookingID"] = $rows["bookingID"];
                        $booking["clinicID"] = $rows["clinicID"];
                        $booking["patientID"] = $rows["patientID"];
                        $booking["bookingDate"] = $rows["bookingDate"];
                        $booking["dateAttended"] = $rows["dateAttended"];
                        $booking["refNumber"] = $rows["refNumber"];
                        $booking["flag"] = $rows["flag"];


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
                        array_push($patient["booking"], $booking);
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


                    // users node
                    $response["patient"] = array();


                    // patient
                    array_push($response["patient"], $patient);


                    // echoing JSON response
                    echo json_encode($response);
                }
            } else {
                // failed to insert row
                $response["success"] = 0;
                $response["message"] = "Oops! An error occurred while registering you. Contact gkelectronics-admin@geekulcha.com";

                // echoing JSON response
                echo json_encode($response);
            }
        } else {
            // required field is missing
            $response["success"] = 0;
            $response["message"] = "Registration Not succesfull";

            // echoing JSON response
            echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Please enter all information";

    // echoing JSON response
    echo json_encode($response);
}
?>