<?php 
session_start();
//check login
if(!isset($_SESSION['username'])){
  header("Location: login.php?redirect=cart.php");
  exit();
}
?>
<!-- php -->
<?php
// Form validation and sanitization
$usernameErr = $emailErr = $phoneErr = $dateErr = $carIdErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['submit'])){


    // Function to clean input data
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check required fields
    $user_id=$_SESSION['username'];
    $username = !empty($_POST['name']) ? clean_input($_POST['name']) : '';
    $email = !empty($_POST['email']) ? clean_input($_POST['email']) : '';
    $phone = !empty($_POST['phone']) ? clean_input($_POST['phone']) : '';
    $preferred_date = !empty($_POST['preferred_date']) ? clean_input($_POST['preferred_date']) : '';
    $car_id = !empty($_POST['car_id']) ? clean_input($_POST['car_id']) : '';


    // Validate username
    if (!$username) {
        $usernameErr="name is required.";
    }
    // Validate email
    if (!$email) {
        $emailErr = "email is required*";
    }
    // Validate phone
    if (!$phone) {
        $phoneErr = "phone is required*";
    } else {
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            $phoneErr = "invalid phone number.";
        }
    }
    // Validate preferred_date
    if (!$preferred_date) {
        $dateErr = "date is required*";
    }
    // Validate car_id
    if (!$car_id) {
        $carIdErr = "car id is required*";
    } else {
        if(filter_var($car_id, FILTER_VALIDATE_INT) === false){
            $carIdErr = "car id must be integer.";
        }
    }


    // Validate email
    if (!$email) {
        $emailErr = "Email is required*";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email address";
    }   


    // If no errors, process registration
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($agreeErr)) {
        echo "registaration data is valid";
        //include database connection
        include('./database/DBController.php');
        $db=new DBController();
        // Get the connection object
        $conn = $db->getConnection();
    if (empty($usernameErr) && empty($emailErr) && empty($phoneErr) && empty($dateErr) && empty($carIdErr)) {
        echo "registration data is valid";
    $query = "INSERT INTO test_drives (user_id, car_id, name, email, phone, preferred_date) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissss", $user_id, $car_id, $username, $email, $phone, $preferred_date);

    if ($stmt->execute()) {
        echo "Test drive scheduled successfully!";
    } else {
    $stmt->bind_param("iissss", $_SESSION['user_id'], $car_id, $username, $email, $phone, $preferred_date);
    }
        }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body >
    <main style="background-image:url(../Resource/Images/logIn.png);
     background-repeat: no-repeat;
  height: 600px;
   background-position: center;
  background-size: cover;">
<header class="sign-up-page-header other-page-header"></header>
<article class="sign-up-page-form">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <h1>Schedule a Test Drive </h1>
    <p>to get Started</p>
    <input class="sign-up-input" required type="text" name="name" placeholder="enter your name"><span class="error"><?= $usernameErr; ?></span><br>
    <input class="sign-up-input" required type="email" name="email" placeholder="email"><span class="error"><?= $emailErr; ?></span><br>
    <input class="sign-up-input" required type="tel" name="phone" placeholder="phone number"><span class="error"><?= $phoneErr; ?></span><br>
    <label for="date">Preferred Test Drive Date:</label>
    <input type="datetime-local" class="sign-up-input" name="preferred_date"><br>
    <span class="error"><?= $dateErr; ?></span><br>
    <label for="car_id">Select Car Id from below list:</label>
    <input type="number" name="car_id"><span class="error"><?= $carIdErr; ?></span>
    <input class="sign-up-input sign-up-input-submit" type="submit" value="Schedule Test Drive" name="submit">
    <br>
    new user? <a href="./signup.php">Register</a>
</form>
</article>
    </main>
    <?php include("./database/display_car.php"); ?>
</body>
</html>

