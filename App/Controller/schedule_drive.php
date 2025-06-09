<?php 
session_start();

// Check login
if (!isset($_SESSION['username'])) {
    header("Location: /car-dealership-fullstack/App/views/auth/login.php");
    exit();
}

require_once __DIR__ . '/../../Core/Database.php';
$db = new App\Core\Database();
$conn = $db->getConnection();

$sessionUsername = $_SESSION['username'];
$usernameErr = $emailErr = $phoneErr = $dateErr = $carIdErr = '';
$cars = [];
$pending_cars = [];
$booked_dates = [];
$successMessage = '';
$errorMessage = '';

// Fetch cars
$cars_stmt = $conn->prepare("SELECT id, name, model, fuelType, price, status FROM cars");
$cars_stmt->execute();
$result = $cars_stmt->get_result();
$cars = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch existing bookings for the user
$pending_stmt = $conn->prepare("SELECT car_id, preferred_date FROM test_drives WHERE username = ? AND status IN ('pending')");
$pending_stmt->bind_param("s", $sessionUsername);
$pending_stmt->execute();
$existing_bookings = $pending_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$pending_cars = array_column($existing_bookings, 'car_id');
$booked_dates = array_column($existing_bookings, 'preferred_date');
$pending_stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $name =$sessionUsername;
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $preferred_date = isset($_POST['preferred_date']) ? $_POST['preferred_date'] : '';
    $car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : 0;
    // Basic Validation
    if (empty($name)) $usernameErr = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailErr = "Invalid email.";
    if (!preg_match('/^\d{10}$/', $phone)) $phoneErr = "Phone must be 10 digits.";
    if (empty($preferred_date)) $dateErr = "Preferred date is required.";
    if ($car_id <= 0) $carIdErr = "Please select a valid car.";

    // Check if user already has any test drive (any status)
    $user_check_stmt = $conn->prepare("SELECT id FROM test_drives WHERE username = ?");
    $user_check_stmt->bind_param("s", $sessionUsername);
    $user_check_stmt->execute();
    $user_check_stmt->store_result();

    if ($user_check_stmt->num_rows > 0) {
        $errorMessage = "You already have a scheduled test drive. Multiple bookings are not allowed.";
        echo "<div style='color: red; font-weight: bold; margin: 20px 0;'>$errorMessage</div>";
        echo "<script>
        setTimeout(function() {
            window.location.href = '/car-dealership-fullstack/App/views/testdrive/schedule_test_drive.php';
        }, 2000);
        </script>";
        $user_check_stmt->close();
        exit();
    } else if (!$usernameErr && !$emailErr && !$phoneErr && !$dateErr && !$carIdErr) {
        // echo "m1";

        
        // Check for existing booking for same car & date
        $check_stmt = $conn->prepare("SELECT id FROM test_drives WHERE car_id = ? AND preferred_date = ? AND status IN ('pending', 'reserved')");
        $check_stmt->bind_param("is", $car_id, $preferred_date);
        $check_stmt->execute();
        $check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
        echo "m2";
            $dateErr = "This car is already booked at the selected date and time.";
            // Show error message and redirect after 2 seconds
            $errorMessage = "Failed to schedule test drive. Car is already booked at the selected date and time. Redirecting...";
            echo "<div style='color: red; font-weight: bold; margin: 20px 0;'>$errorMessage</div>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '/car-dealership-fullstack/App/views/testdrive/schedule_test_drive.php';
            }, 2000);
            </script>";
            if (isset($check_stmt) && $check_stmt instanceof mysqli_stmt) {
                $check_stmt->close();
            }
            if (isset($user_check_stmt) && $user_check_stmt instanceof mysqli_stmt) {
                $user_check_stmt->close();
            }
            // exit();
        } else if (in_array($car_id, $pending_cars)) {
            // Show error message and redirect after 2 seconds
            $errorMessage = "Failed to schedule test drive. You already have a pending test drive for this car. Redirecting...";
            echo "<div style='color: red; font-weight: bold; margin: 20px 0;'>$errorMessage</div>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '/car-dealership-fullstack/App/views/testdrive/schedule_test_drive.php';
            }, 2000);
            </script>";
            $carIdErr = "You already have a pending test drive for this car.";
            if (isset($check_stmt) && $check_stmt instanceof mysqli_stmt) {
                $check_stmt->close();
            }
            if (isset($user_check_stmt) && $user_check_stmt instanceof mysqli_stmt) {
                $user_check_stmt->close();
            }
            exit();
        } else {
            // Insert new test drive request
            $insert_stmt = $conn->prepare("INSERT INTO test_drives (username, car_id, name, email, phone, preferred_date, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
            $insert_stmt->bind_param("sissss", $sessionUsername, $car_id, $name, $email, $phone, $preferred_date);
            if ($insert_stmt->execute()) {
                $updateCarStatusSQL = "UPDATE cars SET status = 'reserved' WHERE id = ?";
                $stmt2 = $conn->prepare($updateCarStatusSQL);
                $stmt2->bind_param("i", $car_id);
                $stmt2->execute();

                // Show success message and redirect after 2 seconds
                $successMessage = "Test drive scheduled! Car is reserved. Redirecting to schedule page...";
            if (isset($insert_stmt) && $insert_stmt instanceof mysqli_stmt) {
                $insert_stmt->close();
            }
            if (isset($stmt2) && $stmt2 instanceof mysqli_stmt) {
                $stmt2->close();
            }
            if (isset($check_stmt) && $check_stmt instanceof mysqli_stmt) {
                $check_stmt->close();
            }
            if (isset($user_check_stmt) && $user_check_stmt instanceof mysqli_stmt) {
                $user_check_stmt->close();
            }
            echo "<div style='color: green; font-weight: bold; margin: 20px 0;'>$successMessage</div>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '/car-dealership-fullstack/App/views/testdrive/schedule_test_drive.php';
            }, 2000);
            </script>";
        } else {
            $errorMessage = "Failed to schedule test drive. Try again.";
            if (isset($insert_stmt) && $insert_stmt instanceof mysqli_stmt) {
                $insert_stmt->close();
            }
            if (isset($stmt2) && $stmt2 instanceof mysqli_stmt) {
                $stmt2->close();
            }
        }
    }
}
}
?>