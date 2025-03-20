<?php
// Form validation and sanitization
$usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = $agreeErr = $registerErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Function to clean input data
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Function to validate username
    function validateUsername($username, &$usernameErr) {
        if (strlen($username) < 3 || strlen($username) > 20) {
            $usernameErr = "Username must be between 3 and 20 characters.";
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $usernameErr = "Username can only contain letters, numbers, underscores, and dashes.";
            return false;
        }

        return true; // Valid username
    }

    // Check required fields
    $username = !empty($_POST['signUpUsername']) ? clean_input($_POST['signUpUsername']) : '';
    $email = !empty($_POST['signUpEmail']) ? clean_input($_POST['signUpEmail']) : '';
    $password = !empty($_POST['signUpPassword']) ? clean_input($_POST['signUpPassword']) : '';
    $confirmPassword = !empty($_POST['signUpCpassword']) ? clean_input($_POST['signUpCpassword']) : '';
    $agree = isset($_POST['signUpCheckBox']) ? clean_input($_POST['signUpCheckBox']) : null;

    // Validate username
    if (!$username) {
        $usernameErr = "Username is required*";
    } else {
        $validUsername = validateUsername($username, $usernameErr);
        if (!$validUsername) {
            $usernameErr = "Invalid username: " . $usernameErr;
        }
    }

    // Validate email
    if (!$email) {
        $emailErr = "Email is required*";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email address";
    }

    // Validate password
    if (!$password) {
        $passwordErr = "Password is required*";
    } elseif (strlen($password) < 6) {
        $passwordErr = "Password is weak. Must be at least 6 characters.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    // Confirm password validation
    if (!$confirmPassword) {
        $confirmPasswordErr = "Confirm password is required*";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordErr = "Confirm password does not match password.";
    }

    // Agree checkbox validation
    if (!$agree) {
        $agreeErr = "You must agree to continue with us.";
    }

    // If no errors, process registration
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($agreeErr)) {
        echo "registaration data is valid";
        //include database connection
        include('./database/DBController.php');
        $db=new DBController();
        $stmt = $db->conn->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();
        echo '<script>alert("register successfully") </script>';
        header('Location: login.php'); // redirec to home page
exit;
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
<body>
    <div class="sign-up-container">
        <form class="sign-up-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="//return validateform()" name="signUpForm">
            <h3>Sign up</h3>
            <p>to get Started</p>
            
            <input class="sign-up-input" type="text" name="signUpUsername" placeholder="Username" ><br>
            <span class="error"><?= $usernameErr; ?></span>
            <input class="sign-up-input"  type="text" name="signUpEmail" placeholder="Email">
            <span class="error"><?= $emailErr; ?></span><br>
            <input class="sign-up-input"  type="password" name="signUpPassword" placeholder="Password">
            <span class="error"><?= $passwordErr; ?></span><br>
            <input class="sign-up-input"  type="password" name="signUpCpassword" placeholder="Confirm Password">
            <span class="error"><?= $confirmPasswordErr; ?></span><br>
            <label><input  type="checkbox" name="signUpCheckBox" value="Agree">Agree to our terms and conditions</label>
            <span class="error"><?= $agreeErr; ?></span><br>
            <button class="sign-up-input sign-up-input-submit" type='submit' name="register">Register</button>
            <br>
            <p>Already registered? <a href="./login.php">Login</a></p>
        </form>
    </div>
    <footer class="sign-up-page-footer other-page-footer">
        <p>Copy right &copy; 2025</p>
    </footer>
    <script src="./JS/script.js">    </script>
</body>
</html>
