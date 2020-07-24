<!doctype html>

<html>

<?php
include_once("others/header_footer.php");
include("others/functions.php");
include("others/DB.php");

$db = new DB();
echo isAlreadyRegistered($db->conn, "ytyty34");
    
?>
    
<body>

    <div class="container">
      
            <div class="offset-md-3 col-xs-12 col-sm-12 col-md-6 px-0 mb-3 text-center">
                <div style="background-color:white; width:70px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:60px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:50px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:40px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:30px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:20px; height:5px; margin-top:2px"></div>
                <div style="background-color:white; width:10px; height:5px; margin-top:2px"></div>
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
    
   <?php
    include("others/footer.php");
    
    ?>
    
    <script src="js/index.js">
    </script>
</body>

</html>