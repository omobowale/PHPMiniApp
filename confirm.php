<! doctype html>

<html>
  
<?php
session_start();
include_once("others/header_footer.php");
require("others/functions.php");
require("others/DB.php");
    
$DB = new DB();

checkAccess(); 
checkRegistrationStatus($DB->conn, "confirm.php");


$details = fetchDetails(decodeAccessCode($_SESSION["acxsc"]));
?>
    


<body>
    <div class="container pt-5">
            <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 pl-0 text-center">
                <div style="background-color:white; width:70px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:60px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:50px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:40px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:30px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:20px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:10px; height:5px; margin-top:2px"></div>
            </div>
            <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 bg-white px-5 mt-2 pb-5">
                <div class="jumobotron text-center">
                    <h2 class="pt-3">Dear <?php echo $details->firstname. " " . $details->lastname ?></h2>
                    <hr>
                    <h5 class="pb-0 mb-0 mt-5 text-left">Your application with the access code <span class="text-danger"><?php if(hash("sha256", decodeAccessCode($_SESSION["acxsc"])) == $details->accesscode) echo decodeAccessCode($_SESSION["acxsc"]) ?></span> is successful.</h5>
                    <br>
                    <h6 class="text-left mb-5 pt-0 pb-5">Kindly print Application Status and Application Details by clicking the buttons below.</h6>
                    <hr class="mb-4 pb-4">
                    <form>
                        <a href="status.php" class="btn btn-info mr-5">Application Status</a>
                        <a href="detail.php" class="btn btn-primary">Application Details</a>
                    </form>

                </div>
            </div>
    </div>
</body>

</html>