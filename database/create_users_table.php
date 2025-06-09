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
$sql="CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'seller', 'user') NOT NULL DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    phone VARCHAR(20),
    INDEX idx_email (email),
    INDEX idx_username (username)
)";
try{
$conn->query($sql);
echo "table is created successfully"."<br>";
}catch(mysqli_sql_exception $e){
    die("unable to connect ".$e->getMessage());
}

?>