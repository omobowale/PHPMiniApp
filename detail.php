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

//GET SUBJECTS FROM THE DETAILS
$subjects = getSubjects($details->bestsubjects);

?>

<body>
    
    <!--CREATE DETAILS PAGE-->
    <div class="container" style="margin-bottom: 90px;">
        
        <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 bg-white px-5 mt-1">
            <div class="jumobotron text-center">
            <?php if(isset($_GET["m"]) and ($_GET["m"] == 1)) echo "<p class='alert alert-info'>You have already registered</p>" ?>
            <h3 class="text-center mt-4 text-info text-uppercase pb-3 pt-4">Applicant's Details</h3>
                 <div class="mt-5" style="border-radius: 50%; height: 200px; width: 200px; margin: auto; border: 1px solid blue">
                        <img style="border-radius: 50%; width:100%; height:100%" src="images/<?php echo $details->image ?>" alt="applicant's image" />
                </div>
                <hr>
                <h5 class="pb-0 pt-5 mb-0 mt-3 text-left">Dear <?php echo $details->firstname. " " . $details->lastname ?>, your application has been received.</h5>
                <h6 class="mb-5 pt-3 pb-5 text-left">Your access code is <span class="text-danger"><?php echo decodeAccessCode($_SESSION["acxsc"]); ?></span>. Kindly go through the details.</h6>
                <hr>
            </div>
            
            
            <div class="pb-1 mb-5">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Address:</th>
                    </tr>
                    <tr>
                        <td><?php echo $details->address ?></td>
                    </tr>
                    <tr>
                        <th>Marital Status:</th>
                    </tr>
                    <tr>
                        <td><?php echo $details->maritalstatus ?></td>
                    </tr>
                    <tr>
                        <th>Educational Background</th>
                    </tr>
                    <tr>
                        <td><?php echo $details->edubg ?></td>
                    </tr>
                    <tr>
                        <th>Best subjects</th>
                    </tr>
                    <tr>
                        <td><ul class="list" style="list-style: none; padding-left: 0">
                            <?php 
                                foreach($subjects as $subject){  ?>
                                    <li><?php echo strtoupper($subject); ?></li>
                                <?php }
                            ?>
                        </ul>
                        </td>
                    </tr>
                    <tr>
                        <th>Religion:</th>
                    </tr>
                    <tr>
                        <td><?php echo $details->religion ?></td>
                    </tr>
                    <tr>
                        <th>State of origin:</th>
                    </tr>
                    <tr>
                        <td><?php echo $details->stateoforigin ?></td>
                    </tr>
                    <tr>
                        <th>Date of birth</th>
                    </tr>
                    <tr>
                        <td><?php echo $details->dob ?></td>
                    </tr>
                </table>
                
                <div class="text-center">
                    <a href="status.php" class="btn btn-info mb-5">Application Status</a>
                </div>
            
            </div>
        </div>        
    </div>     <!--END OF .container DIV-->
    
     
</body>

</html>