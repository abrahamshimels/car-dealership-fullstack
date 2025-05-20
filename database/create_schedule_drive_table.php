<?php
include_once __DIR__.'/../Core/Database.php';
use App\Core\Database;

class CreateTable{

    private mysqli $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function creatUser(){
        
    }

    public function getConnection() {
        return $this->db;
    }

}

$dbConn= new CreateTable();
$conn=$dbConn->getConnection();
$sql="CREATE TABLE IF NOT EXISTS test_drives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    car_id INT,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(15),
    preferred_date DATETIME,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
try{
$conn->query($sql);
echo "table is created successfully"."<br>";
}catch(mysqli_sql_exception $e){
    die("unable to connect ".$e->getMessage());
}


?>