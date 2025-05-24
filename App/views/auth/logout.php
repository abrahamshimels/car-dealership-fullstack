<?php
session_start();
$_SESSION['username']=null;
$_SESSION['user_id']=null;

header("location: /car-dealership-fullstack/App/views/Home/index.php");
exit();

?>