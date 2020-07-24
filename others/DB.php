<?php

class DB{
    
    const servername = "localhost";
    const username = "root";
    const password = "";
    const dbname = "bbtapplication";
    public $conn = null;
    
    function __construct(){
        $this->conn = new mysqli(DB::servername, DB::username, DB::password, DB::dbname) or die("Error o : " . mysqli_connect_error());
    }
    
    function get_conn(){
        return $this->conn;
    }
    
    public function close_conn(){
        $this->conn->close();
    }
    
    
    
    
}

?>