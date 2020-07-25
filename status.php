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
checkRegistrationStatus($DB->conn, "status.php");
       
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
    
    <!--CREATE STATUS PAGE-->
    <div class="container" style="margin-bottom: 90px;">
        
            <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 bg-white px-5 mt-1">
                <div class="jumobotron text-center">
                    <h3 class="text-center mt-4 text-info text-uppercase pb-3 pt-4">Applicant's Status</h3>
                    <div class="mt-5" style="border-radius: 50%; height: 200px; width: 200px; margin: auto; border: 1px solid blue">
                        <img style="border-radius: 50%; width:100%; height:100%" src="images/<?php echo $details->image ?>" alt="applicant's image" />
                </div>
                    <hr>
                    <h5 class="pb-0 mb-0 text-left">I, <span class="text-danger"><?php echo $details->firstname . " " . $details->lastname ?></span>, applied with the application code <span class="text-danger"><?php echo decodeAccessCode($_SESSION["acxsc"]) ?></span>.</h5>
                    <h6 class="mb-5 mt-2 pt-0 text-left">I live at <span class="text-danger"><?php echo $details->address ?></span> and I was born on <span class="text-danger"><?php echo $details->dob ?></span></h6>
                    <hr>
                    <h5 class="text-left">My favourite subjects are: </h5>
                    <ul class="list text-left" style="list-style: none">
                        <?php 
                            foreach($subjects as $subject){  ?>
                                <li class="list-items text-danger text-left ml-0 pl-0"><?php echo strtoupper($subject); ?></li>
                            <?php 
                            }
                        ?>
                        
                    </ul>
                    <hr>
                    <a href="detail.php" class="btn btn-info mb-5">Application Details</a>

                </div>
        </div>
    </div>
    
    
    
</body>

</html>