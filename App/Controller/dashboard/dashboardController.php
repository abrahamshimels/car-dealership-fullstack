<?php
session_start();

// Check login
if (!isset($_SESSION['username'])) {
    header("Location: /car-dealership-fullstack/App/views/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../../Core/Database.php';
$db = new App\Core\Database();
$conn = $db->getConnection();

$sessionUsername = $_SESSION['username'];
$stmt = $conn->prepare("SELECT role FROM users WHERE username = ?");
$stmt->bind_param("s", $sessionUsername);
$stmt->execute();
$stmt->bind_result($userRole);
$stmt->fetch();
$stmt->close();

echo $sessionUsername;
echo $userRole;
if($userRole=='admin'){
    header("Location: /car-dealership-fullstack/App/views/admin/dashboard.php");
    exit();
}else{
    header("Location: /car-dealership-fullstack/index.php");
    exit();
}

?>