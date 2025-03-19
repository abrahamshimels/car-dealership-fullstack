<?php
// Including the database class (if in a separate file)
include_once('DBController.php');

// Create a new instance of DBController
$db = new DBController();

// Get the connection object
$conn = $db->getConnection();

//query to creat test_drive list table
$sql="CREATE TABLE test_drives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT, -- reference to the user if they are logged in
    car_id INT, -- reference to the car model for the test drive
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(15),
    preferred_date DATETIME,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
try{
$conn->query($sql);
// echo "table is created successfully"."<br>";
}catch(mysqli_sql_exception $e){
    die("unable to connect ".$e->getMessage());
}

?>