<?php 
session_start();

// Check login
if (!isset($_SESSION['username'])) {
    header("Location: /car-dealership-fullstack/App/views/auth/login.php");
    exit();
}
echo "come";
require_once __DIR__ . '/../../Core/Database.php';
$db = new App\Core\Database();
$conn = $db->getConnection();

$sessionUsername = $_SESSION['username'];
$usernameErr = $emailErr = $phoneErr = $dateErr = $carIdErr = '';
$cars = [];


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_id'])) {
    $car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : 0;
    // Basic Validation
    if ($car_id <= 0) $carIdErr = "Please select a valid car.";


if (!$carIdErr) {
            // update table to status completed where car_id==?

                $updateCarStatusSQL = "UPDATE test_drives SET status = 'completed' WHERE car_id = ?";
                $stmt2 = $conn->prepare($updateCarStatusSQL);
                $stmt2->bind_param("i", $car_id);
                $stmt2->execute();

                // Show success message and redirect after 2 seconds
                $successMessage = "Test drive scheduled approve!Redirecting to schedule page...";

            echo "<div style='color: green; font-weight: bold; margin: 20px 0;'>$successMessage</div>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '/car-dealership-fullstack/App/views/admin/testDrive.php';
            }, 2000);
            </script>";  
}
}
?>