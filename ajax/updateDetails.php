<?php
include_once("../config.php");
session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
  if($_SESSION['auth']) {
    $oldusername = $_SESSION['username'];
    $id = $_SESSION['id'];
    $permissions = $_SESSION['permissions'];
    $password = $_POST['password'];
    $hashedPassword = hash("sha512", $password);
    $newusername = $_POST['username'];
    $isRight = mysqli_fetch_array(mysqli_query($cn, "SELECT id FROM `users` WHERE id='$id' AND `username`='$oldusername' AND `permissions`='$permissions' AND `password`='$hashedPassword' LIMIT 1"));
    
    if(!isset($isRight['id'])) {
      echo "Wrong Password";
      exit;
    }

    
    $user = mysqli_fetch_array(mysqli_query($cn, "SELECT * FROM `users` WHERE username='$newusername'"));
    if(!isset($user['id'])) {
      if(mysqli_query($cn, "UPDATE `users` SET `username`='$newusername' WHERE id='$id' AND `password`='$hashedPassword'")) {
        echo "Username Update Succesfully";
        $_SESSION['username'] = $newusername;
        exit;
      } else {
        echo "Something went wrong! Please try again later";
        exit;
      }
    } else {
      echo "Username already used.";
    }


    
  }
}

if (isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {
  if($_SESSION['auth']) {
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
    $permissions = $_SESSION['permissions'];
    $oldpassword = $_POST['oldPassword'];
    $oldHashedPassword = hash("sha512", $oldpassword);
    $newpassword = $_POST['newPassword'];
    $newHashedPassword = hash("sha512", $newpassword);
    
    $isCorrect = mysqli_fetch_array(mysqli_query($cn, "SELECT id FROM `users` WHERE id='$id' AND `username`='$username' AND `permissions`='$permissions' AND `password`='$oldHashedPassword' LIMIT 1"));
    
    if(!isset($isCorrect['id'])) {
      echo "Wrong Password";
      exit;
    }

    if(mysqli_query($cn, "UPDATE `users` SET `password`='$newHashedPassword' WHERE id='$id' AND username='$username'")) {
      echo "Password Update Successfully";
    } else {
      echo "Something went wrong! Please try again later";
      exit;
    }
  }




}