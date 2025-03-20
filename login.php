<?php
// Start session to store user login state
session_start();
//error container to display for user 
$usernameErr=$passwordErr=$emailErr='';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $redirect=isset($_POST['redirect']) ? $_POST['redirect'] : 'index.php';
    // Function to clean input data
    function clean_input($data) {
        // $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username=clean_input($_POST['name']);
    $password=clean_input($_POST['password']);
    if(empty($username) && empty($emial)){
      echo "all fields are required";
    }else{
      include("./database/DBController.php");
      $db=new DBController();
      $stmt=$db->conn->prepare("SELECT * FROM users where username=? LIMIT 1");
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $result=$stmt->get_result();
      //fetch
      $user=$result->fetch_assoc();
      if($user){
        echo "user name is found:".$user['username'];
        if(password_verify($password,$user['password'])){
          echo "login successfully";
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo '<script>alert("login successfully") </script>';
            header('Location: '.$redirect); // Redirect to a desire page
            exit;
        }else{
          $passwordErr="incorrect password.";
        }
      }else{
        $usernameErr="user name is Not found";
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
    <link rel="stylesheet" href="./CSS/style.css">
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
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <legend></legend>
    <h3>Login</h3>
    <p>to get Started</p>
    <input class="sign-up-input" required type="text" name="name" placeholder="Username">
    <span class="error"><?= $usernameErr; ?></span>
    <br>
      <input class="sign-up-input" required type="password" name="password" placeholder="password">
      <span class="error"><?= $passwordErr; ?></span><br>
      <!-- <a href="#" class="forgot-password">Forgot Password?</a> -->
    <input class="sign-up-input sign-up-input-submit" type="submit" value="Contiue">
    <br>
    New User? <a href="./signup.php">Register</a>
   <br>
     <a href="../index.php">Home page</a>
</form>
    
</article>
    </main>

</body>
</html>
