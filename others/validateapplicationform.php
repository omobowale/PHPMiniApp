<?php
session_start();
require("DB.php");
require("functions.php");

$error = "";
$subjects = "";

//All variables;
$firstname = "";
$lastname = "";
$address = "";
$dob = "";
$stateoforigin = "";
$maritalstatus = "";
$religion = "";
$edubg = "";
$image = "";
$bestsubjects = "";


//Check for firstname
if(empty($_POST["firstname"]) | !isset($_POST["firstname"])){
    $error .= "Please enter your first name<br>";
}
else {
    //store the firstname input in a variable
    $firstname = $_POST["firstname"];
    //sanitize the firstname input
    if($firstname != filter_var($firstname, FILTER_SANITIZE_STRING)){
        $error .= "Please enter a valid first name<br>";  
    }
    else{
        $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
    }
    
}


//Check for lastname
if(empty($_POST["lastname"]) | !isset($_POST["lastname"])){
    $error .= "Please enter your last name<br>";
}
else {
     //store the lastname input in a variable
    $lastname = $_POST["lastname"];
    //sanitize the lastname input
    if($lastname != filter_var($lastname, FILTER_SANITIZE_STRING)){
        $error .= "Please enter a valid last name<br>";  
    }
    else{
        $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    }
    
}


//Check for address
if(empty($_POST["address"]) | !isset($_POST["address"])){
    $error .= "Please enter your address<br>";
}
else {
    //store the address input in a variable
    $address = $_POST["address"];
    //sanitize the address input
    if($address != filter_var($address, FILTER_SANITIZE_STRING)){
        $error .= "Please enter a valid address<br>";  
    }
    else{
        $address = filter_var($address, FILTER_SANITIZE_STRING);
    }
    
}


//Check for marital status
if(!isset($_POST["maritalstatus"])){
    $error .= "Please select your marital status<br>";
}

else {
     //store the maritalstatus input in a variable
    $maritalstatus = $_POST["maritalstatus"];  
}


//Check for educational background
if(!isset($_POST["edubg"])){
    $error .= "Please enter details of your educational background<br>";
}
else {
     //store the edubg input in a variable
    $edubg = $_POST["edubg"];
    //sanitize the edubg input
    if($edubg != filter_var($edubg, FILTER_SANITIZE_STRING)){
        $error .= "Your educational background contains some invalid texts<br>";  
    }
    else{
        $edubg = filter_var($edubg, FILTER_SANITIZE_STRING);
    }
    
}


//Check for subjects
if(isset($_POST["maths"])){
   $subjects .= $_POST["maths"] . ",";
}

if(isset($_POST["english"])){
   $subjects .= $_POST["english"] . ",";
}

if(isset($_POST["civic"])){
   $subjects .= $_POST["civic"] . ",";
}

if(isset($_POST["computer"])){
   $subjects .= $_POST["computer"] . ",";
}

if(isset($_POST["science"])){
   $subjects .= $_POST["science"] . ",";
}

if(isset($_POST["government"])){
   $subjects .= $_POST["government"] . ",";
}

if(isset($_POST["art"])){
   $subjects .= $_POST["art"] . ",";
}

if(isset($_POST["history"])){
   $subjects .= $_POST["history"] . ",";
}

if(isset($_POST["agriculture"])){
   $subjects .= $_POST["agriculture"] . ",";
}

//Check if at least one subject is selected
if($subjects == ""){
    $error .= "Please select at least one subject<br>";
}

else{
    //remove the last comma from the subject
    $bestsubjects = substr($subjects, 0, -1);
}


//Check for religion
if(empty($_POST["religion"]) | !isset($_POST["firstname"])){
    $error .= "Please select your religion<br>";
}
else {
    //sanitize the string
    $religion = $_POST["religion"];
    
}


//Check for state of origin
if(empty($_POST["stateoforigin"]) | !isset($_POST["stateoforigin"])){
    $error .= "Please enter your state of origin<br>";
}
else {
     //store the state of origin input in a variable
    $stateoforigin = $_POST["stateoforigin"];
    //sanitize the stateoforigin input
    if($stateoforigin != filter_var($stateoforigin, FILTER_SANITIZE_STRING)){
        $error .= "Your educational background contains some invalid texts<br>";  
    }
    else{
        $stateoforigin = filter_var($stateoforigin, FILTER_SANITIZE_STRING);
    }
    
}


//Check for date of birth
if(!isset($_POST["dob"])){
    $error .= "Please enter your date of birth<br>";
}
else {
    $dob = $_POST["dob"];
}


//Check for image
if($_FILES["file"]["error"] > 0){
    $error .= "Please select an image<br>";
}
else {
    $filename =  $_FILES["file"]["name"];     
    $filetype = $_FILES["file"]["type"];
    if(validateImageUsing($filename, $filetype) == -1){
        $error .= "Only images of type jpg, gif, bmp or png are allowed<br>";
    }
    else if(validateImageUsing($filename, $filetype) == 0){
        $error .= "Image size too large: Please select an image less than 2MB<br>";
    }
    else if(validateImageUsing($filename, $filetype) == 1){
        $image = $filename;
    }
    else {
        $error .= "Unknown error during image upload. Please try again later<br>";
    }
    
}
   
if($error != ""){
    echo $error;
}

else{
    //Insert all fields into database
    $DB = new DB();
    
    //Get access code of current applicant
    $accesscode = decodeAccessCode($_SESSION["acxsc"]);
    
    //hash the access code
    $accesscode = hash("sha256", $accesscode);
    
    $result = insertIntoDatabaseTable($DB->conn, $accesscode, $firstname, $lastname, $address, $maritalstatus, $edubg, $bestsubjects, $religion, $stateoforigin, $dob, $image);
    
    if($result == -1){
        echo "Error in connection";
    }

    else if($result == 0){
        echo hash("sha256", "0");;
        //echo "Error: Applicaton already exists";      
    }
    
    else if($result == 1){
        echo hash("sha256", "1");
    }

    else {
        echo "Unknown error";
    }
    
    $DB->close_conn();
    
   //insertIntoDatabaseTable($DB->conn, $firstname, $lastname, $address, $maritalstatus, $edubg, $bestsubjects, $religion, $stateoforigin, $dob, $image);
    
}

?>