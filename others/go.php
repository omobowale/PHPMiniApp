<?php


if(isset($_GET['data'])){
    $data = $_GET['data'];
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    
    if($data == hash("sha256", "valid")){
        //echo 1;
        header("location: ../apply.php");
    }
    
    else if($data == hash("sha256", "exists")){
        //echo 2;
        header("location: ../detail.php?m=1");
    }
    
    else{
       // echo 3;
       header("location: ../login.php");
    }
}

else if(isset($_GET['response'])){
    $data = $_GET['response'];
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    
    if($data == hash("sha256", "1")){
        header("location: ../confirm.php");
    }
    else if($data == hash("sha256", "0")){
        header("location: ../status.php");
    }
    
    else{
       header("location: ../login.php");
    }
}

else{
    header("location: ../login.php");
}

?>