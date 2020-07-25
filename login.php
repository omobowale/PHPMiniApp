<!doctype html>

<html>

<?php
//INCLUDE NECESSARY FILES
include_once("others/header_footer.php");
include("others/functions.php");
include("others/DB.php");
    
?>
    
<body>
    
    <!--CREATE LOGIN FORM-->
    <div class="container">
      
            <div class="offset-md-3 col-xs-12 col-sm-12 col-md-6 px-0 mb-3 mt-4 text-center">
                <div style="background-color:white; width:61px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:50px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:40px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:31px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:23px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:16px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:10px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:5px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:1px; height:5px; margin-top:2px"></div>
            </div>
            <div class="offset-md-3 col-xs-12 col-sm-12 col-md-6 bg-white px-5 pt-2" style="height:350px;">
                <h3 class="text-center mt-4 text-info text-uppercase pb-3">Login</h3>
                <form id="loginform" method="post">
                    <p id="message"></p>
                    <div class="form-group">
                        <span id="accesscodespan" class="pl-2 bg-white text-info" style="display:none; position: relative; top:10px; left:4px; padding-right:7px">Access Code</span>
                        <label class="sr-only">Access Code:</label>
                        <input style="border:0px solid blue; border-radius:0; border-bottom:1px solid gray; padding-top:30px; padding-bottom:30px" class="text-info form-control mb-4" id="accesscodeinput" type="text" name="accesscode" required="true" placeholder="Access Code" />
                    </div>
                    <button style="font-weight:bold; letter-spacing:1.5px; border:1px solid white; padding-top:20px; padding-bottom:40px" type="submit" name="submit" class="btn btn-info form-control">submit</button>
                </form>
            </div>
      
    </div>
    
  
    <!--INCLUDE THE JS FILE TO PROCESS LOGIN FORM-->
    <script src="js/index.js">
    </script>
</body>

</html>