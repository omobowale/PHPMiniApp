<?php
session_start();

require("DB.php");
require("functions.php");

$db = new DB();

$data = $_POST["val"];
$data = filter_var($data, FILTER_SANITIZE_STRING);


checkdata($data);


function checkdata($data){
    $message = "";
    
    //is data empty or null?
    if($data == null || $data == "" || empty($data)){
        $message = "<span class='text-danger'>Please enter access code</span>";

    }
    
    else{
        if(preg_match("/[\!@#$%^&*();:\"<>']/", $data)){
            $message = "<span class='text-danger'>Invalid access code</span>";
        }

        else {
            $db = new DB();
            if(accessCodeExists($db->get_conn(), "accesscode", hash("sha256", $data), "accesscodestable") and accessCodeIsUnique($db->get_conn(), "accesscode_id", hash("sha256", $data), "applicationdetails")){
                //create session with the access code
                $_SESSION["acxsc"] = encodeAccessCode($data);
                $message = hash("sha256", "valid");
                $db->close_conn();
            }
            
            else if(accessCodeIsUnique($db->get_conn(), "accesscode", hash("sha256", $data), "accesscodestable") and accessCodeIsUnique($db->get_conn(), "accesscode_id", hash("sha256", $data), "applicationdetails") and strlen($data) == 7){
                //create session with the access code
                $_SESSION["acxsc"] = encodeAccessCode($data);
                $message = hash("sha256", "valid");
                $db->close_conn();
            }
            
            else if(accessCodeExists($db->get_conn(), "accesscode", hash("sha256", $data), "accesscodestable") and accessCodeExists($db->get_conn(), "accesscode_id", hash("sha256", $data), "applicationdetails")){
                //create session with the access code
                $_SESSION["acxsc"] = encodeAccessCode($data);
                $message = hash("sha256", "exists");
                $db->close_conn();
            }

            else{
                $message = "<span class='text-danger'>Access code does not exist</span>";
            }
        }
    }
    
    echo $message;
}



?>

