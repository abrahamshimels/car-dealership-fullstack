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
$sql="CREATE TABLE IF NOT EXISTS cars (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0,
    previousPrice DECIMAL(10,2),
    rate DECIMAL(3,2) NOT NULL DEFAULT 0,
    imageUrl VARCHAR(2048),
    model VARCHAR(30) NOT NULL,
    descriptions TEXT NOT NULL,
    fuelType ENUM('petrol', 'diesel', 'electric', 'hybrid') NOT NULL,
    status ENUM('available', 'sold', 'reserved') NOT NULL DEFAULT 'available',
    seller_id INT(10) UNSIGNED,
    registerDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE SET NULL
    )";
try{
$conn->query($sql);
echo "table is created successfully"."<br>";
}catch(mysqli_sql_exception $e){
    die("unable to connect ".$e->getMessage());
}


?>