<?php
require("Details.php");


//=============================ACCESS CODE FUNCTIONS==============================

//function to generate access code. This is for the admin
function generateAccessCode(){
    $permittedChars = "0123456789abcdefghijklmnopqrstuvwxyz";
    echo substr(str_shuffle($permittedChars), 0, 7);
}


//function to check if access code exists, is valid, or is invalid
function checkdata($data){
    $message = "";
    
    //is access code empty or null?
    if($data == null || $data == "" || empty($data)){
        $message = "<span class='text-danger'>Please enter access code</span>";

    }
    
    else{
        //if access code contains any special character
        if(preg_match("/[\!@#$%^&*\s();:\"<>']/", $data)){
            $message = "<span class='text-danger'>Invalid access code</span>";
        }

        //otherwise, they can be used
        else {
            //create a new database object
            $db = new DB();
            
            //if the access code exists in accesscodetables table but does not exist in the applicationdetails table in the database, then it is valid
            if(accessCodeExists($db->get_conn(), "accesscode", hash("sha256", $data), "accesscodestable") and accessCodeIsUnique($db->get_conn(), "accesscode_id", hash("sha256", $data), "applicationdetails")){
                //create session with the access code
                $_SESSION["acxsc"] = encodeAccessCode($data);
                $message = hash("sha256", "valid");
                $db->close_conn();
            }
            
            //instead, if the access code does not exist on both tables and its length is exactly 7, then it is valid
            else if(accessCodeIsUnique($db->get_conn(), "accesscode", hash("sha256", $data), "accesscodestable") and accessCodeIsUnique($db->get_conn(), "accesscode_id", hash("sha256", $data), "applicationdetails") and strlen($data) == 7){
                //create session with the access code
                $_SESSION["acxsc"] = encodeAccessCode($data);
                $message = hash("sha256", "valid");
                $db->close_conn();
            }
            
            //instead, if the access code exists on both tables, then it already exists: user has already registered
            else if(accessCodeExists($db->get_conn(), "accesscode", hash("sha256", $data), "accesscodestable") and accessCodeExists($db->get_conn(), "accesscode_id", hash("sha256", $data), "applicationdetails")){
                //create session with the access code
                $_SESSION["acxsc"] = encodeAccessCode($data);
                $message = hash("sha256", "exists");
                $db->close_conn();
            }

            //Otherwise,
            else{
                $message = "<span class='text-danger'>Access code is unknown</span>";
            }
        }
    }
    
    echo $message;
}


//function to encode a string
function encode_this($string){
    $permittedChars = "0123456789abcdefghijklmnopqrstuvwxyxABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $equivalentRepresentation = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $newString = "";
    
    for($i=0; $i<strlen($string); $i++){
        $index = strpos($permittedChars, $string[$i]);
        $newString .= $equivalentRepresentation[$index];
    }
    
    return $newString;
    
}


//function to decode a string
function decode_this($string){
   $permittedChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789" ;
    $equivalentRepresentation = "0123456789abcdefghijklmnopqrstuvwxyxABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $newString = "";
    
    for($i=0; $i<strlen($string); $i++){
        $index = strpos($permittedChars, $string[$i]);
        $newString .= $equivalentRepresentation[$index];
    }
    
    return $newString;
}


//function to encode the access code before storing in the session
function encodeAccessCode($accesscode){
    $firststring = bin2hex(openssl_random_pseudo_bytes(15));
    $string = encode_this($accesscode);
    $secondstring = bin2hex(openssl_random_pseudo_bytes(10));
    return $coded = $firststring.$string.$secondstring;
}


//function to decode access code before using outside the session
function decodeAccessCode($accesscode){
     $result = substr($accesscode, 30, 7);
    return decode_this($result);
    
}


//function to check if access code is unique on database table
function accessCodeIsUnique($conn, $column, $value, $table){
                
    if(!$conn){
        die("Error: " . mysqli_connect_error());
        return false;
    }
    
    $sql = "SELECT * FROM " . $table . " WHERE " . $column . " = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    
    if(!$stmt->execute()){
        return false;
    }
    
    if(!($result = $stmt->get_result())){
        return false;
    }
    else{
        if(mysqli_num_rows($result) == 0){
            return true;
        }
        else {
            return false;
        }
    }
    
    $conn.close();
     
}


//function to check if access code exists
function accessCodeExists($conn, $column, $value, $table){
                
    if(!$conn){
        die("Error: " . mysqli_connect_error());
        return false;
    }
    
    $sql = "SELECT * FROM " . $table . " WHERE " . $column . " = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    
    if(!$stmt->execute()){
        //echo "not executed";
        return false;
    }
    
    if(!($result = $stmt->get_result())){
        //echo "no result";
        return false;
    }
    else{
        if(mysqli_num_rows($result) == 1){
            //echo "one row returned";
            return true;
        }
        else {
            //echo "no row returned";
            return false;
        }
    }
     
}


//function to insert access code into database table - accesscodestable
function insertAccessCodeIntoDB($conn, $accesscode){
    
    //First check if accesscode is unique on database table
    if(accessCodeIsUnique($conn, "accesscode", $accesscode, "accesscodestable")){
 
        $sql = "INSERT INTO accesscodestable (accesscode, registrationstatus) VALUE (?, ?)";

        if(!($stmt = $conn->prepare($sql))){
            //echo $conn->errno . " +++ " . $conn->error;
            return -1;
        }

        $status = 1;
        if(!$stmt->bind_param("si", $accesscode, $status)){
            //echo $stmt->errno . "   +++++ " . $stmt->error;
            return -1;
        }
        
        if($stmt->execute() != 1){
               return -1;
        }
        
        else{
            return 1;
        }
        
        
    }
    
    else {
            return 0;
        }

    
}


//function to check if accesscode is valid
function accessCodeIsValid($conn, $accesscode){
    
    if(!$conn){
        die("Error: " . mysqli_connect_error());
    }
    
    $safe_accesscode = $conn->real_escape_string($accesscode);
    $enc_accesscode = hash("sha256", $safe_accesscode);
    
    $sql = "SELECT * FROM accesscodestable WHERE accesscode = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $enc_accesscode);
    
    if(!$stmt->execute()){
        return false;
    }
        
    if(!($result = $stmt->get_result())){
        return false;
    }
    else{
        if(mysqli_num_rows($result) == 1){
            if(accessCodeIsUnique($conn, "accesscode_id", $enc_accesscode, "applicationdetails")){
                return true;
            }
        }
        else {
            return false;
        }
    }
     
}







//=============================DATABASE FUNCTIONS==============================


//function to insert application form inputs into database
function insertIntoDatabaseTable($conn, $accesscode_id, $firstname, $lastname, $address, $maritalstatus, $edubg, $bestsubjects, $religion, $stateoforigin, $dob, $image){
    
    $image = uploadImage($image);
    
    //$accesscode_id = hash("sha256", $accesscode);
    
    //First check if accesscode is unique on database table
    if(accessCodeIsUnique($conn, "accesscode_id", $accesscode_id, "applicationdetails")){
 
        $sql = "INSERT INTO applicationdetails (accesscode_id, firstname, lastname, address, maritalstatus, edubg, bestsubjects, religion, stateoforigin, dateofbirth, imageupload) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if(!($stmt = $conn->prepare($sql))){
            //echo $conn->errno . " +++ " . $conn->error;
            return -1;
        }

        if(!$stmt->bind_param("sssssssssss", $accesscode_id, $firstname, $lastname, $address, $maritalstatus, $edubg, $bestsubjects, $religion, $stateoforigin, $dob, $image)){
            //echo $stmt->errno . "   +++++ " . $stmt->error;
            return -1;
        }
        
        if($stmt->execute() != 1){
               return -1;
        }
        
        else{
            if(insertAccessCodeIntoDB($conn, $accesscode_id) == 1){
                return 1;
            }
            return -1;
        }
        
        
    }
    
    else {
            return 0;
        }

}


//function to set details of logged in user
function setDetails($conn, $accesscode, Details $details){
    
    $accesscode = hash("sha256", $accesscode);
    if(!$conn){
        die("Error : " . mysqli_connect_error());
    }
    
    $sql = "SELECT * FROM applicationdetails WHERE accesscode_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $accesscode);
    
    if(!$stmt->execute()){
        die($stmt->errno . $stmt->error);
    }
    
    if(!($result = $stmt->get_result())){
        echo "Error : " . $result->errno . $result->error;
    }
    else{
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $details->id = $row["id"];
            $details->accesscode = $row["accesscode_id"];
            $details->firstname = $row["firstname"];
            $details->lastname = $row["lastname"];
            $details->address = $row["address"];
            $details->maritalstatus = $row["maritalstatus"];
            $details->religion = $row["religion"];
            $details->edubg = $row["edubg"];
            $details->dob = $row["dateofbirth"];
            $details->bestsubjects = $row["bestsubjects"];
            $details->stateoforigin = $row["stateoforigin"];
            $details->image = $row["imageupload"];
        }
    }
    
    
    return $details;
    
}


//function to fetch details of logged in user
function fetchDetails($accesscode){
    $DB = new DB();
    $details = setDetails($DB->conn, $accesscode, new Details());
    return $details;
}


//function to get the subjects of logged in user
function getSubjects($subjects){
    $allsubjects = preg_split("/\,/", $subjects);
    return $allsubjects;
}



//=============================USER ACCESS AND STATUS FUNCTIONS==============================

//function to check if a user is already registered
function isAlreadyRegistered($conn, $accesscode){
    $accesscode = hash("sha256", $accesscode);
    
    if(!$conn){
        die("Error: " . mysqli_connect_error());
        return false;
    }
    
    $sql = "SELECT registrationstatus FROM accesscodestable WHERE accesscode = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $accesscode);
    
    if(!$stmt->execute()){
        return false;
    }
    
    if(!($result = $stmt->get_result())){
        return false;
    }
    else{
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $row["registrationstatus"];
        }
        else {
            
            return false;
        }
    }
    
    $conn.close();
    
}


//function to check for registration status of user
function checkRegistrationStatus($conn, $page){
    
    $accesscode = decodeAccessCode($_SESSION["acxsc"]);
    if(isAlreadyRegistered($conn, $accesscode) == 1 and $page == "apply.php"){
            header("location: detail.php?m=1");
        }
    else if(isAlreadyRegistered($conn, $accesscode) != 1 and $page != "apply.php"){
            header("location: apply.php");
    }
   
}


//function to check if user has access to a page or not
function checkAccess(){
    
    if(!isset($_SESSION["acxsc"])){
        header("location: login.php");
    }
    
}





//=============================OTHER FUNCTIONS==============================

//function to validate image
function validateImageUsing($filename, $filetype){
        $acceptabletypes = array("image/png", "image/jpeg", "image/gif", "image/bmp");
        $filetype = $_FILES["file"]["type"];
    
        if(!in_array($filetype, $acceptabletypes)){
            return -1;
        }

        else if($_FILES["file"]["size"] > 2*1024*1024){
            return 0;
        }
        
        else{
            return 1;
        }
    
}


//function to upload image
function uploadImage($image){
        
        $defaultImage = "backgroundimg.jpg";
    
        //Create a unique image every time.
        $timestamp = time();
        $newfilename = $timestamp .basename($image);
    
        $uploadfolder = "../images/". $newfilename;
    
        //move image to images folder
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfolder)){
            return $newfilename;
        }
    
    return $defaultImage;
}





?>