<?php
include_once("../config.php");

if(isset($_POST['username'])) {
  $username = $_POST['username'];
  
  $user = mysqli_fetch_array(mysqli_query($cn, "SELECT * FROM `users` WHERE username='$username'"));
  echo (isset($user['id'])) ? "true" : "false";
  exit;
}