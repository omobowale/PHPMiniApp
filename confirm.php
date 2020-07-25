<?php 

//START SESSION
session_start();

//REQUIRE THE NECESSARY FILES
require("others/functions.php");     //ALL FUNCTIONS ARE DEFINED IN THIS FILE
require("others/DB.php");            //DATABASE FUNCTIONS ARE DEFINED IN THIS FILE

//CREATE DATABASE OBJECT FROM DB CLASS (DEFINED IN "DB.php" file in "others" folder)
$DB = new DB();

//CHECK IF USER HAS ACCESS TO PAGE (FUNCTION IS DEFINED IN "functions.php" file in "others" folder)
checkAccess();

//CHECK IF USER HAS REGISTERED OR NOT (FUNCTION IS DEFINED IN "functions.php" file in "others" folder)
checkRegistrationStatus($DB->conn, "apply.php");
       
?>

<!--BEGIN HTML-->
<! doctype html>
<html>
  
<?php
//INCLUDE THE HEADER AND FOOTER
include_once("others/header_footer.php");

//FETCH DETAILS OF USER
$details = fetchDetails(decodeAccessCode($_SESSION["acxsc"]));
?>
    


<body>
    <div class="container pt-5">
            <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 bg-white px-5 mt-2 pb-5">
                <div class="jumobotron text-center mb-5">
                    <h2 class="pt-3">Dear <?php echo $details->firstname. " " . $details->lastname ?></h2>
                    <hr>
                    <h5 class="pb-0 mb-0 mt-5 text-left">Your application with the access code <span class="text-danger"><?php if(hash("sha256", decodeAccessCode($_SESSION["acxsc"])) == $details->accesscode) echo decodeAccessCode($_SESSION["acxsc"]) ?></span> is successful.</h5>
                    <br>
                    <h6 class="text-left mb-5 pt-0 pb-5">Kindly print Application Status and Application Details by clicking the buttons below.</h6>
                    <hr class="mb-4 pb-4">
                    <form>
                        <a href="status.php" class="btn btn-info btn-block">Application Status</a>
                        <a href="detail.php" class="btn btn-primary btn-block mb-4">Application Details</a>
                    </form>

                </div>
            </div>
    </div>
</body>

</html>