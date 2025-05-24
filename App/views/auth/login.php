<?php
use App\Core\Database;
// Start session to store user login state
session_start();
//error container to display for user 
$usernameErr=$passwordErr=$emailErr='';
if($_SERVER["REQUEST_METHOD"]=="POST"){
  
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '/car-dealership-fullstack/App/views/Home/index.php';
    // Function to clean input data
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username=clean_input($_POST['name']);
    $password=clean_input($_POST['password']);
    if(empty($username) || empty($password)){
      echo "All fields are required";
    } else {
      //data connection
      include_once __DIR__.'/../../../Core/Database.php';
      $db = new Database();
      $db->getConnection();
      $stmt=$db->conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $result=$stmt->get_result();
      //fetch
      $user=$result->fetch_assoc();
      if($user){
        // // echo "user name is found:".$user['username'];
        // echo "<script>alert('user name is found: " . $user['username'] . "');</script>";
        if(password_verify($password,$user['password_hash'])){
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          header('Location: '.$redirect); // Redirect to a desired page
          exit;
        }else{
          $passwordErr="Incorrect data.";
        }
      }else{
        $usernameErr="Incorrect data";
      }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="/car-dealership-fullstack/public/assets/Images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/car-dealership-fullstack/public/assets/CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" >
    <style>.error{color:red;}</style>
</head>
<body >
    <main style="background-image:url(../Resource/Images/logIn.png);
     background-repeat: no-repeat;
  height: 600px;
   background-position: center;
  background-size: cover;">
<header class="sign-up-page-header"></header>
<article class="sign-up-page-form">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <legend></legend>
    <h3>Login</h3>
    <p>to get Started</p>
    <span class="error"><?= $usernameErr; ?></span>
    <span class="error"><?= $passwordErr; ?></span><br>
    <input class="sign-up-input" required type="text" name="name" placeholder="Username">
    <br>
      <input class="sign-up-input" required type="password" name="password" placeholder="password">
      <!-- <a href="#" class="forgot-password">Forgot Password?</a> -->
    <input class="sign-up-input sign-up-input-submit" type="submit" value="Continue">
    <br>
    New User? <a href="./signup.php">Register</a>
   <br>
     <a href="../Home/index.php">Home page</a>
</form>
    
</article>
    </main>

</body>
</html>
