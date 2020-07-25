<?php
//class to hold database connection details
//it contains the servername, username, password, database name, and connection to the server
class DB{
    
    const servername = "localhost";           //replace this with your server name
    const username = "stiga_admin";           //replace this with your database username
    const password = "147258stiga";           //replace this with your database password
    const dbname = "stiga_bbtapplication";    // replace this with your database name
    public $conn = null;                    
    
    
    //constructor to initialize server properties and database
    function __construct(){
        $this->conn = new mysqli(DB::servername, DB::username, DB::password, DB::dbname) or die("Error o : " . mysqli_connect_error());
    }
    
    //function to get connection
    function get_conn(){
        return $this->conn;
    }
    
    //function to close connection
    public function close_conn(){
        $this->conn->close();
    }
    
    
}

?>