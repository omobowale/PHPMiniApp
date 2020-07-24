<! doctype html>

<html>
  
<?php
include_once("others/header.php");
require("others/functions.php");
require("others/DB.php");
    
$DB = new DB();
accessCodeExists($DB->conn, "accesscode_id", hash("sha256", "tyrter5"), "applicationdetails");

?>

<body>
    <div class="container">
        <h3 class="text-center mt-5">Login</h3>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-8 col-md-6">
                <form>
                    <div class="form-group mt-4">
                        <label>Access Code:</label>
                        <input class="form-control mb-4" type="text" required="true" placeholder="Input Code Here"/>
                    </div>
                    <button class="btn btn-primary form-control">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>