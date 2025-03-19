<?php
// Including the database class (if in a separate file)
include_once('DBController.php');

// Create a new instance of DBController
$db = new DBController();

// Get the connection object
$conn = $db->getConnection();

//query to creat users list table
$sql="CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,   
    username VARCHAR(50) NOT NULL UNIQUE, 
    email VARCHAR(100) NOT NULL UNIQUE,     
    password VARCHAR(255) NOT NULL,           
    profile_picture VARCHAR(255),              
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
)";
try{
$conn->query($sql);
// echo "table is created successfully"."<br>";
}catch(mysqli_sql_exception $e){
    die("unable to connect ".$e->getMessage());
}

?>