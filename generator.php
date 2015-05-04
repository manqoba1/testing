<?php
 
/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();

// check for require fields
$json_results = json_decode($_GET["json"]);


if ($json_results->name && $json_results->latitude && $json_results->longitude ) {
 
    $name = $json_results->name;
    $latitude = $json_results->latitude;
    $longitude = $json_results->longitude;
	
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
	
	//encrypting the password
	//$encrypt=md5($password);
 
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO country(name,longitude,latitude) 
	VALUES('$name','$longitude', '$latitude')");
    
	echo mysql_error();
    
    // check if row inserted or not
	
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message1"] = "country successfully created.";
        
        //select country to insert province in
        $resul = mysql_query("SELECT * FROM country WHERE name = '$name'") or die(mysql_error());
        while ($row = mysql_fetch_array($resul)) {
            $countryid = $row["countryID"];
        }
        //insert province in country
        $result = mysql_query("INSERT INTO province(countryID,name,longitude,latitude) 
	       VALUES('$countryid','Gauteng','25.36', '25.26')");
        echo mysql_error();
        
        
        if ($result) {
            $response["message2"] = "province successfully created.";
            
            //select province to insert town in
            $resul = mysql_query("SELECT * FROM province WHERE name = 'Gauteng'") or die(mysql_error());
            while ($row = mysql_fetch_array($resul)) {
                $prov_id = $row["provinceID"];
            }
            //insert town in province
            $result1 = mysql_query("INSERT INTO town(provinceID,name,longitude,latitude) 
	           VALUES('$prov_id','Diepsloot','25.36', '25.26')");
            echo mysql_error();
            
            if ($result1) {
                $response["message3"] = "town successfully created.";
                
                //select town to insert clinic in
                $resul = mysql_query("SELECT * FROM town WHERE name = 'Diepsloot'") or die(mysql_error());
                while ($row = mysql_fetch_array($resul)) {
                    $town_id = $row["townID"];
                }
                //insert clinic  in town
                for( $i=1; $i<5; $i++){
                    $clinic_name = "DiepslootClinic $i";
                    $email = "DKL$i@sloot.com";
                    $result1 = mysql_query("INSERT INTO clinic(townID,name,phoneNumber,email,password,longitude,latitude) 
	                   VALUES('$town_id','$clinic_name','0115681125', '$email','1235s','26.51','26.45')");
                    echo mysql_error();
                    
                    
                
                 
                    if ($result1) {
                        $response["message4"] = "$clinic_name successfully created.";
                    }
                    
                    //select clinic to insert staff in
                    $resuls = mysql_query("SELECT * FROM clinic WHERE name = '$clinic_name'") or die(mysql_error());
                    while ($row = mysql_fetch_array($resuls)) {
                        $clinic_id = $row["clinicID"];
                    }
                        $nam = "mike $i";
                        $nam1 = "moloka $i";
                        $nam2 = "kroka $i";
                        $mail = "moloka $i@gmail.com";
                    
                     $result2 = mysql_query("INSERT INTO staff(clinicID,firstName,middleName,lastName,phoneNumber,email,password) 
	                   VALUES('$clinic_id','$nam','$nam1', '$nam2','012365426','$mail','75sd25s')");
                    echo mysql_error();
                    
                    if ($result2) {
                        $response["message5"] = "$nam successfully created.";
                    }
                    
                    
                    $zam = "adam $i";
                        $zam1 = "mkgethwa $i";
                        $zam2 = "kroka $i";
                        $zmail = "mK $i@gmail.com";
                    
                    $result3 = mysql_query("INSERT INTO patient(firstName,middleName,lastName,phoneNumber,email,password) 
	                   VALUES('$zam','$zam1', '$zam2','012365426','$zmail','75sd25s')");
                    echo mysql_error();
                    if ($result3) {
                        $response["message6"] = "$zam successfully created.";
                    }
                    
                    //select patient to book
                    $resuls = mysql_query("SELECT * FROM patient WHERE firstName = '$zam'") or die(mysql_error());
                    while ($row = mysql_fetch_array($resuls)) {
                        $patient_id = $row["patientID"];
                    }
                    $result4 = mysql_query("INSERT INTO booking(clinicID,patientID,bookingDate,dateAttended,refNumber,flag) 
	                   VALUES('$clinic_id','$patient_id','now()', 'now()','012365dfsf426','1')");
                    echo mysql_error();
                    
                    if ($result4) {
                        $response["message7"] = "booking successfully created.";
                    }
                    
                }
                
            }
            
            
        }
        
 
        // echoing JSON response
        echo json_encode($response);
        
        
        
        
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
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