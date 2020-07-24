<?php
require("Details.php");

function generateAccessCode(){
    $permittedChars = "0123456789abcdefghijklmnopqrstuvwxyz";
    echo substr(str_shuffle($permittedChars), 0, 7);
}


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

function encodeAccessCode($accesscode){
    $firststring = bin2hex(openssl_random_pseudo_bytes(15));
    $string = encode_this($accesscode);
    $secondstring = bin2hex(openssl_random_pseudo_bytes(10));
    return $coded = $firststring.$string.$secondstring;
}

function decodeAccessCode($accesscode){
     $result = substr($accesscode, 30, 7);
    return decode_this($result);
    
}



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

function fetchDetails($accesscode){
    $DB = new DB();
    $details = setDetails($DB->conn, $accesscode, new Details());
    return $details;
}

function getSubjects($subjects){
    $allsubjects = preg_split("/\,/", $subjects);
    return $allsubjects;
}

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

function checkRegistrationStatus($conn, $page){
    
    $accesscode = decodeAccessCode($_SESSION["acxsc"]);
    if(isAlreadyRegistered($conn, $accesscode) == 1 and $page == "apply.php"){
            header("location: detail.php?m=1");
        }
    else if(isAlreadyRegistered($conn, $accesscode) != 1 and $page != "apply.php"){
            header("location: apply.php");
    }
   
}

function checkAccess(){
    
    if(!isset($_SESSION["acxsc"])){
        header("location: login.php");
    }
    
}




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


function uploadImage($image){
        
        $defaultImage = "backgroundimage2.jpg";
    
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