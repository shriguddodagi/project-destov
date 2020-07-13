<?php

function uploadImage($image) {
  $target_dir = "storage/";
  $target_file_path = $target_dir . time() . basename($image["name"]);
  $imageFileType = strtolower(pathinfo($target_file_path,PATHINFO_EXTENSION));

  return (move_uploaded_file($image["tmp_name"], $target_file_path)) ? $target_file_path : false;
}

function validType($image) {
  $imageFileType = strtolower(pathinfo($image["name"],PATHINFO_EXTENSION));
  return ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) ? false : true;
}

function recordSanitize($POST) {
 	$name = FormSanitizer::sanitizeFormNameNumber($POST['name']);
    $email = FormSanitizer::sanitizeFormEmail($POST['email']);
    $phone = FormSanitizer::sanitizeFormNameNumber($POST['phone']);
    $message = $POST['message'];
    $check = $_POST['check'];
    return "INSERT INTO `inquiries` (name, email, phone, message, check_mode) VALUES('$name', '$email', '$phone', '$message', '$check')";
}












?>