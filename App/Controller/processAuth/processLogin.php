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
          $passwordErr="Incorrect password.";
        }
      }else{
        $usernameErr="Username is not found";
      }
    }
}

?>