<?php 

//START SESSION
session_start();

//REQUIRE THE NECESSARY FILES
require("others/functions.php");
require("others/DB.php");

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

?>

<body>
    
    <!--CREATE APPLICATION FORM-->
    <div class="container" style="margin-bottom: 90px;">       
        <div class="offset-md-2 col-xs-12 col-sm-12 col-md-8 bg-white px-5">
            <h3 class="text-center mt-4 text-info text-uppercase pb-3 pt-4">Online Application</h3>
            
            <div class="col-12 pb-5 mb-5">
                <div class="mt-4 mb-0"><a id="info"><p id="message"></p></a></div>
                <form class="mt-0" id="applicationform" method="post" enctype="multipart/form-data">
                     <?php if(isset($_SESSION["acxsc"])) echo "<label>Access Code : </label><p class='alert alert-info'>" .decodeAccessCode($_SESSION["acxsc"]) . "</p>"?>
                    <span class="text-danger">*All inputs are required*</span>
                    <div class="form-group mt-3">
                        <label>First Name: </label>
                        <input class="form-control mb-4" type="text" name="firstname"  placeholder="Enter First Name" required />
                    </div>

                    <div class="form-group mt-4">
                        <label>Last Name: </label> 
                        <input class="form-control mb-4" type="text" name="lastname" placeholder="Enter Last Name" required />
                    </div>

                    <div class="form-group mt-4">
                        <label>Address: </label>
                        <input class="form-control mb-4" type="text" name="address" placeholder="Enter Address" required />
                    </div>

                    <div class="form-group mt-4">
                        <p>Marital Status: </p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="single" name="maritalstatus" value="Single" required />
                            <label class="form-check-label" for="single">Single</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="married" name="maritalstatus" value="Married" required />
                            <label class="form-check-label" for="married">Married</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="divorced" name="maritalstatus" value="Divorced" required />
                            <label class="form-check-label" for="divorced">Divorced</label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label>Educational Background: </label>
                        <input class="form-control mb-4" type="text" name="edubg" placeholder="Enter Educational Background" required />
                    </div>

                    <div class="form-group mt-4">
                        <p>Select Best Subject(s): </p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="maths" name="maths" value="Mathematics"  />
                            <label class="form-check-label" for="maths">Mathematics</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="english" name="english" value="English" />
                            <label class="form-check-label" for="english">English</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="science" name="science" value="Science" />
                            <label class="form-check-label" for="science">Science</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="government" name="government" value="Government" />
                            <label class="form-check-label" for="government">Government</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="art" name="art" value="Art" />
                            <label class="form-check-label" for="art">Art</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="civic" name="civic" value="Civic"  />
                            <label class="form-check-label" for="civic">Civic</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="computer" name="computer" value="Computer" />
                            <label class="form-check-label" for="computer">Computer</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="history" name="history" value="History" />
                            <label class="form-check-label" for="history">History</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agriculture" name="agriculture" value="Agriculture" />
                            <label class="form-check-label" for="agriculture">Agriculture</label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <p>Religion: </p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="islam" name="religion" value="islam" required />
                            <label class="form-check-label" for="islam">Islam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="christianity" name="religion" value="christianity" required />
                            <label class="form-check-label" for="christianity">Christianity</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="traditional" name="religion" value="traditional" required  />
                            <label class="form-check-label" for="traditional">Traditional</label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label>State of Origin: </label>
                        <input class="form-control mb-4" type="text" name="stateoforigin"  placeholder="Enter State of Origin" required />
                    </div>

                    <div class="form-group mt-4">
                        <label>Date of Birth: </label>
                        <input class="form-control mb-4" type="date" name="dob" required />
                    </div>

                    <div class="form-group mt-4">
                        <label>Image Upload: </label>
                        <input class="form-control mb-4" type="file" name="file" id="file" required />
                    </div>

                    <button style="font-weight:bold; letter-spacing:1.5px; border:1px solid white; padding-top:20px; padding-bottom:40px" type="submit" name="submit" class="btn btn-info form-control">submit application</button>
                </form>
            </div>
        </div>
    </div>
    
    <!--INCLUDE JS FILE TO PROCESS APPLICATION FORM-->
    <script src="js/index.js">
        
        
    
    </script>
    
</body>

</html>