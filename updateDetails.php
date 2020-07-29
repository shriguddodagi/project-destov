<?php
include_once("./config.php");
session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
  if($_SESSION['auth']) {
    $oldusername = $_SESSION['username'];
    $id = $_SESSION['id'];
    $permissions = $_SESSION['permissions'];
    $password = $_POST['password'];
    $newusername = $_POST['username'];
    $isRight = mysqli_fetch_array(mysqli_query($cn, "SELECT id FROM `users` WHERE id='$id' AND `username`='$oldusername' AND `permissions`='$permissions' AND `password`='$password' LIMIT 1"));
    
    if(!isset($isRight['id'])) {
      echo "Wrong Password";
      exit;
    }

    if(mysqli_query($cn, "UPDATE `users` SET `username`='$newusername' WHERE id='$id' AND `password`='$password'")) {
      echo "Username Update Succesfully";
      $_SESSION['username'] = $newusername;
    } else {
      echo "Something went wrong! Please try again later";
      exit;
    }
  }
}

if (isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {
  if($_SESSION['auth']) {
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
    $permissions = $_SESSION['permissions'];
    $oldpassword = $_POST['oldPassword'];
    $newpassword = $_POST['newPassword'];
    
    $isCorrect = mysqli_fetch_array(mysqli_query($cn, "SELECT id FROM `users` WHERE id='$id' AND `username`='$username' AND `permissions`='$permissions' AND `password`='$oldpassword' LIMIT 1"));
    
    if(!isset($isCorrect['id'])) {
      echo "Wrong Password";
      exit;
    }

    if(mysqli_query($cn, "UPDATE `users` SET `password`='$newpassword' WHERE id='$id' AND username='$username'")) {
      echo "Password Update Successfully";
    } else {
      echo "Something went wrong! Please try again later";
      exit;
    }
  }




}