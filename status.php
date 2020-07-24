<! doctype html>

<html>
  
<?php
session_start();
include_once("others/header_footer.php");
require("others/functions.php");
require("others/DB.php");
    
$DB = new DB();

checkAccess(); 
checkRegistrationStatus($DB->conn, "status.php");
    
$details = fetchDetails(decodeAccessCode($_SESSION["acxsc"]));
$subjects = getSubjects($details->bestsubjects);

?>

<body>
    
    <div class="container">
        
        <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 p-0 mt-2">
                <div style="background-color:white; width:70px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:60px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:50px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:40px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:30px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:20px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:10px; height:5px; margin-top:2px"></div>
        </div>
        
        <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 bg-white px-5 mt-1 pb-5 mb-5">
                <div class="jumobotron text-center">
                    <h3 class="text-center mt-4 text-info text-uppercase pb-3 pt-4">Applicant's Status</h3>
                    <div style="border-radius: 50%; height: 200px; width: 200px; margin: auto; border: 1px solid blue">
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
                    <a href="detail.php" class="btn btn-info">Application Details</a>

                </div>
        </div>
    </div>
    
    
</body>

</html>