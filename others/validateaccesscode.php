<?php

//START SESSION
session_start();

//INCLUDE THE REQUIRED FILES
require("DB.php");
require("functions.php");

//CREATE NEW CONNECTION TO DATABASE
$db = new DB();

//GET DATA (which is the access code) FROM POST REQUEST
$data = $_POST["accesscode"];

//SANITIZE THE DATA
$cdata = filter_var($data, FILTER_SANITIZE_STRING);

//CHECK IF DATA IS VALID
echo checkdata($cdata);


?>

