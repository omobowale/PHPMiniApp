<?php
//THIS PAGE HELPS TO REDIRECT FROM PAGES GIVEN BY AJAX CALL TO THE ACTUAL PAGES

//if data parameter is sent to the url by the Ajax, then request is from login.php
if(isset($_GET['data'])){
    //get the data and sanitize it
    $data = $_GET['data'];
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    
    //if the sanitized data has a hash value of "valid", then the user is new: allow them to register
    if($data == hash("sha256", "valid")){
        header("location: ../apply.php");
    }
    
    //if instead, it has a hash value of "exists", then the user has already registered: no need to register, direct them to the details page
    else if($data == hash("sha256", "exists")){
        header("location: ../detail.php?m=1");
    }
    
    //otherwise, go back to login
    else{
       header("location: ../login.php");
    }
}

//if response parameter is sent instead by the Ajax, then request is from apply.php
else if(isset($_GET['response'])){
    //get the response value and sanitize it
    $data = $_GET['response'];
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    
    //if the sanitized data has a hash value of "1", then the user is new: details has been inserted into database
    if($data == hash("sha256", "1")){
        header("location: ../confirm.php");
    }
    
    //if instead, it has a hash value of "2", then the user has already registered: details will not be inserted
    else if($data == hash("sha256", "0")){
        header("location: ../status.php");
    }
    
    //otherwise,
    else{
       header("location: ../login.php");
    }
}


//if neither the response nor the data parameter is sent by the Ajax
else{
    header("location: ../login.php");
}

?>